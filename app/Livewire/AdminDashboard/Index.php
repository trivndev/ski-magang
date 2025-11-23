<?php

namespace App\Livewire\AdminDashboard;

use App\Models\DashboardMetric;
use App\Models\Internship;
use App\Models\InternshipsPostStatus;
use App\Services\DashboardMetricsService;
use App\Traits\WithNotify;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin'), Title('Admin Dashboard')]
class Index extends Component
{
    use WithNotify;

    public function approvePost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Approved');
        if ($res) {
            $this->notifySuccess('Success', 'Post approved.');
        } else {
            $this->notifyWarning('Failed', 'Action is not allowed.');
        }
    }

    public function rejectPost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Rejected');
        if ($res) {
            $this->notifySuccess('Success', 'Post rejected.');
        } else {
            $this->notifyWarning('Failed', 'Action is not allowed.');
        }
    }

    public function banPost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Banned');
        if ($res) {
            $this->notifySuccess('Success', 'Post banned.');
        } else {
            $this->notifyWarning('Failed', 'Action is not allowed.');
        }
    }

    protected function updatePostStatus(string $postId, string $statusName): bool
    {
        $admin = auth()->user();
        if (!$admin || !$admin->can('manage post')) {
            return false;
        }
        $statusId = InternshipsPostStatus::query()
            ->whereRaw('LOWER(status) = ?', [strtolower($statusName)])
            ->value('id');

        if (!$statusId) {
            return false;
        }

        $post = Internship::withTrashed()->find($postId);
        if (!$post) {
            return false;
        }

        if (method_exists($post, 'trashed') && $post->trashed()) {
            return false;
        }

        $post->update(['status_id' => $statusId]);

        DashboardMetricsService::refresh();
        return true;
    }

    public function render()
    {
        $metric = DashboardMetric::query()->latest('snapshot_at')->first();
        $shouldRefresh = !$metric;

        if ($metric) {
            $shouldRefresh = now()->diffInMinutes($metric->snapshot_at ?? now()) >= 5;
            if (!$shouldRefresh) {
                $top = (array) ($metric->top_liked_posts ?? []);
                $missing = collect($top)->contains(function ($p) {
                    $requiredAny = [
                        'address',
                        'status',
                        'contact_phone',
                        'contact_name',
                        'job_description',
                        'requirements',
                        'benefits',
                        'end_date',
                    ];
                    foreach ($requiredAny as $key) {
                        if (!array_key_exists($key, (array) $p)) {
                            return true;
                        }
                    }
                    return empty(data_get($p, 'address'))
                        || empty(data_get($p, 'status'))
                        || empty(data_get($p, 'job_description'))
                        || empty(data_get($p, 'requirements'));
                });
                $shouldRefresh = $missing;
            }
        }

        if ($shouldRefresh) {
            $metric = DashboardMetricsService::refresh();
        }

        return view('livewire.admin-dashboard.index', [
            'metric' => $metric,
        ]);
    }
}
