<?php

namespace App\Services;

use App\Models\DashboardMetric;
use App\Models\Internship;
use App\Models\InternshipsPostStatus;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardMetricsService
{
    /**
     * Compute and persist the latest dashboard metrics snapshot.
     */
    public static function refresh(): DashboardMetric
    {
        $now = Carbon::now();
        $statusIds = InternshipsPostStatus::query()
            ->pluck('id', 'status')
            ->mapWithKeys(fn ($id, $name) => [strtolower($name) => $id]);

        $approvedId = $statusIds['approved'] ?? null;
        $rejectedId = $statusIds['rejected'] ?? null;
        $pendingId  = $statusIds['pending']  ?? null;

        $totalPosts = Internship::query()->count();
        $postsThisMonth = Internship::query()
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $approvedCount = $approvedId ? Internship::query()->where('status_id', $approvedId)->count() : 0;
        $rejectedCount = $rejectedId ? Internship::query()->where('status_id', $rejectedId)->count() : 0;
        $pendingCount  = $pendingId  ? Internship::query()->where('status_id', $pendingId)->count()  : 0;

        $deletedPosts = Internship::onlyTrashed()->count();

        $start = $now->copy()->startOfMonth()->subMonths(11);
        $end = $now->copy()->endOfMonth();

        $period = CarbonPeriod::create($start, '1 month', $end);
        $monthlySeries = [];
        $monthlyUserSeries = [];

        $countsByYm = Internship::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as cnt')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        $userCountsByYm = User::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as cnt')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        foreach ($period as $month) {
            $ym = $month->format('Y-m');
            $monthlySeries[] = [
                'month' => $ym,
                'count' => (int) ($countsByYm[$ym] ?? 0),
            ];
            $monthlyUserSeries[] = [
                'month' => $ym,
                'count' => (int) ($userCountsByYm[$ym] ?? 0),
            ];
        }

        $threshold = $now->copy()->subDays(30);
        $recentUserIds = User::query()
            ->where(function ($q) use ($threshold) {
                $q->whereNotNull('email_verified_at')->where('email_verified_at', '>=', $threshold)
                  ->orWhere('created_at', '>=', $threshold);
            })
            ->pluck('id')
            ->all();

        $recentAuthors = Internship::query()
            ->where('created_at', '>=', $threshold)
            ->pluck('author_id')
            ->all();

        $activeUsers = count(collect($recentUserIds)->merge($recentAuthors)->unique());

        // Top 10 most-liked posts (cached as lightweight array)
        $topLiked = Internship::query()
            ->withCount('likes')
            ->with(['author:id,name', 'vocationalMajor:id,major_name'])
            ->orderByDesc('likes_count')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get(['id','job_title','company','author_id','vocational_major_id','created_at'])
            ->map(function ($p) {
                return [
                    'id' => (string) $p->id,
                    'title' => $p->job_title,
                    'company' => $p->company,
                    'likes' => (int) ($p->likes_count ?? 0),
                    'author' => optional($p->author)->name,
                    'major_name' => optional($p->vocationalMajor)->major_name,
                    'created_at' => optional($p->created_at)->toDateString(),
                ];
            })
            ->values()
            ->all();

        return DB::transaction(function () use ($now, $totalPosts, $postsThisMonth, $approvedCount, $rejectedCount, $pendingCount, $deletedPosts, $activeUsers, $monthlySeries, $monthlyUserSeries, $topLiked) {
            return DashboardMetric::query()->create([
                'snapshot_at' => $now,
                'total_posts' => $totalPosts,
                'posts_this_month' => $postsThisMonth,
                'approved_count' => $approvedCount,
                'rejected_count' => $rejectedCount,
                'pending_count' => $pendingCount,
                'active_users' => $activeUsers,
                'deleted_posts' => $deletedPosts,
                'monthly_series' => $monthlySeries,
                'monthly_user_series' => $monthlyUserSeries,
                'top_liked_posts' => $topLiked,
            ]);
        });
    }
}
