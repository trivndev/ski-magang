<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Internship;
use App\Models\InternshipsPostStatus;
use App\Services\DashboardMetricsService;
use App\Traits\WithQueryFilterAndSearch;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin'), Title('Admin Dashboard')]
class PostsList extends Component
{
    use WithPagination, WithQueryFilterAndSearch, WithNotify;

    public function mount(): void
    {
        $this->initDraftFiltersFromUrl();
    }

    public function approvePost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Approved');
        if ($res['ok'] ?? false) {
            $this->notifySuccess('Success', 'Post approved.');
        } else {
            $this->notifyWarning('Failed', $res['reason'] ?? 'Action is not allowed.');
        }
    }

    public function rejectPost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Rejected');
        if ($res['ok'] ?? false) {
            $this->notifySuccess('Success', 'Post rejected.');
        } else {
            $this->notifyWarning('Failed', $res['reason'] ?? 'Action is not allowed.');
        }
    }

    public function banPost(string $postId): void
    {
        $res = $this->updatePostStatus($postId, 'Banned');
        if ($res['ok'] ?? false) {
            $this->notifySuccess('Success', 'Post banned.');
        } else {
            $this->notifyWarning('Failed', $res['reason'] ?? 'Action is not allowed.');
        }
    }

    public function changeStatus(string $postId, string $statusName): void
    {
        $statusName = trim($statusName);
        if ($statusName === '' || $statusName === 'deleted') {
            $this->notifyInfo('Info', 'No changes were made.');
            return;
        }
        $result = $this->updatePostStatus($postId, $statusName);

        if (!$result['ok']) {
            $reason = $result['reason'] ?? 'Action is not allowed.';
            $this->notifyWarning('Failed', $reason);
            return;
        }

        $this->notifySuccess('Success', 'Post status has been updated.');
    }

    protected function updatePostStatus(string $postId, string $statusName): array
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage post')) {
            return ['ok' => false, 'reason' => 'You do not have permission.'];
        }

        $statusId = InternshipsPostStatus::query()
            ->whereRaw('LOWER(status) = ?', [strtolower($statusName)])
            ->value('id');

        if (!$statusId) {
            return ['ok' => false, 'reason' => 'Unknown status.'];
        }

        $post = Internship::withTrashed()->find($postId);
        if (!$post) {
            return ['ok' => false, 'reason' => 'Post not found.'];
        }

        if (method_exists($post, 'trashed') && $post->trashed()) {
            return ['ok' => false, 'reason' => 'Post has been deleted.'];
        }

        $currentStatus = strtolower(optional($post->status)->status ?? '');
        $targetStatus = strtolower($statusName);

        $allowedTargets = [];
        if ($currentStatus === 'pending' || $currentStatus === '') {
            $allowedTargets = ['approved', 'rejected'];
        } elseif (in_array($currentStatus, ['approved', 'rejected', 'banned'], true)) {
            $allowedTargets = ['approved', 'rejected', 'banned'];
        } elseif ($currentStatus === 'deleted') {
            $allowedTargets = [];
        }

        if (!in_array($targetStatus, $allowedTargets, true)) {
            return ['ok' => false, 'reason' => 'Status transition is not allowed.'];
        }

        $post->update(['status_id' => $statusId]);

        DashboardMetricsService::refresh();

        return ['ok' => true];
    }

    public function render()
    {
        $fields = ['job_title', 'company', 'location'];
        $keyword = trim($this->searchQuery ?? '');

        $query = Internship::query()
            ->withTrashed()
            ->withCount('likes')
            ->with(['author:id,name', 'vocationalMajor:id,major_name', 'status:id,status'])
            ->when($keyword !== '', function ($q) use ($fields, $keyword) {
                $q->where(function ($qq) use ($fields, $keyword) {
                    foreach ($fields as $field) {
                        $qq->orWhere($field, 'like', "%{$keyword}%");
                    }
                });
            });

        if (!empty($this->selectedMajor)) {
            $query->whereIn('vocational_major_id', $this->selectedMajor);
        }

        switch ($this->sortBy) {
            case 'likes':
                $query->orderByDesc('likes_count');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $posts = $query->paginate(10);

        return view('livewire.admin-dashboard.posts-list', [
            'posts' => $posts,
            'canManage' => Auth::user()?->can('manage post') ?? false,
        ]);
    }
}
