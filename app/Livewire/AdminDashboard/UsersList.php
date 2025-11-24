<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithNotify;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role as SpatieRole;

#[Layout('components.layouts.admin'), Title('Admin Dashboard | Users')]
class UsersList extends Component
{
    use WithPagination, WithNotify;

    public string $draftSearchQuery = '';
    public string $searchQuery = '';

    public string $draftSortBy = 'newest';
    public string $sortBy = 'newest';
    public array $draftSelectedStatus = [];
    public array $selectedStatus = [];
    public array $selectedRoles = [];

    public function banUser(string $userId): void
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage user')) {
            $this->notifyWarning('Failed', 'You do not have permission.');
            return;
        }
        $user = User::find($userId);
        if (!$user) {
            $this->notifyWarning('Failed', 'User not found.');
            return;
        }
        if (!$admin->hasRole('supervisor') && $user->hasRole('supervisor')) {
            $this->notifyWarning('Failed', 'You cannot act on a supervisor.');
            return;
        }
        $user->banned_at = now();
        $user->save();
        $this->notifySuccess('Success', 'User has been banned.');
    }

    public function unbanUser(string $userId): void
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage user')) {
            $this->notifyWarning('Failed', 'You do not have permission.');
            return;
        }
        $user = User::find($userId);
        if (!$user) {
            $this->notifyWarning('Failed', 'User not found.');
            return;
        }
        if (!$admin->hasRole('supervisor') && $user->hasRole('supervisor')) {
            $this->notifyWarning('Failed', 'You cannot act on a supervisor.');
            return;
        }
        $user->banned_at = null;
        $user->save();
        $this->notifySuccess('Success', 'User has been unbanned.');
    }

    public function verifyUser(string $userId): void
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage user')) {
            $this->notifyWarning('Failed', 'You do not have permission.');
            return;
        }
        $user = User::find($userId);
        if (!$user) {
            $this->notifyWarning('Failed', 'User not found.');
            return;
        }
        $user->email_verified_at = now();
        $user->save();
        $this->notifySuccess('Success', 'User has been verified.');
    }

    public function unverifyUser(string $userId): void
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage user')) {
            $this->notifyWarning('Failed', 'You do not have permission.');
            return;
        }
        $user = User::find($userId);
        if (!$user) {
            $this->notifyWarning('Failed', 'User not found.');
            return;
        }
        $user->email_verified_at = null;
        $user->save();
        $this->notifySuccess('Success', 'User verification has been removed.');
    }

    public function setUserRole(string $userId, $roleName): void
    {
        $admin = Auth::user();
        if (!$admin || !$admin->can('manage role')) {
            $this->notifyWarning('Failed', 'You do not have permission.');
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            $this->notifyWarning('Failed', 'User not found.');
            return;
        }

        $roleName = is_string($roleName) ? trim($roleName) : '';
        if ($roleName === '') {
            $this->notifyWarning('Failed', 'Invalid role.');
            return;
        }

        $roleExists = SpatieRole::where('name', $roleName)->exists();
        if (!$roleExists) {
            $this->notifyWarning('Failed', 'Role does not exist.');
            return;
        }

        $user->syncRoles([$roleName]);

        $this->selectedRoles[$userId] = $roleName;
        $this->notifySuccess('Success', 'User role has been updated.');
    }

    public function searchUser(): void
    {
        $this->searchQuery = trim($this->draftSearchQuery);
        $this->resetPage();
    }

    public function searchPost(): void
    {
        $this->searchUser();
    }

    public function clearFilters(): void
    {
        $this->draftSearchQuery = '';
        $this->draftSortBy = 'newest';
        $this->draftSelectedStatus = [];

        $this->searchQuery = '';
        $this->sortBy = 'newest';
        $this->selectedStatus = [];
        $this->resetPage();
    }

    public function applyFilters(): void
    {
        $this->searchQuery = trim($this->draftSearchQuery);
        $this->sortBy = $this->draftSortBy ?: 'newest';
        $this->selectedStatus = $this->draftSelectedStatus;
        $this->resetPage();
    }

    public function render()
    {
        $query = User::with(['roles']);

        if ($this->searchQuery !== '') {
            $raw = trim($this->searchQuery);
            $numericCandidate = preg_replace('/\D+/', '', $raw);
            $q = '%' . str_replace(['%', '_'], ['\%', '\_'], $raw) . '%';

            $query->where(function ($sub) use ($q, $numericCandidate) {
                $sub->where('name', 'like', $q)
                    ->orWhere('email', 'like', $q);

                if ($numericCandidate !== '' && ctype_digit($numericCandidate)) {
                    $sub->orWhere('id', (int)$numericCandidate);
                }
            });
        }

        if (!empty($this->selectedStatus)) {
            $statuses = array_map('strtolower', $this->selectedStatus);
            $query->where(function ($sub) use ($statuses) {
                foreach ($statuses as $status) {
                    if ($status === 'banned') {
                        $sub->orWhereNotNull('banned_at');
                    } elseif ($status === 'verified') {
                        $sub->orWhere(function ($inner) {
                            $inner->whereNull('banned_at')
                                ->whereNotNull('email_verified_at');
                        });
                    } elseif ($status === 'unverified') {
                        $sub->orWhere(function ($inner) {
                            $inner->whereNull('banned_at')
                                ->whereNull('email_verified_at');
                        });
                    }
                }
            });
        }

        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10);

        $admin = Auth::user();
        $isSupervisor = $admin?->hasRole('supervisor') ?? false;
        $roles = $isSupervisor ? SpatieRole::query()->orderBy('name')->get(['name']) : collect();

        foreach ($users as $u) {
            /** @var User $u */
            $this->selectedRoles[(string)$u->id] = $u->getRoleNames()->first();
        }
        return view('livewire.admin-dashboard.users-list', [
            'users' => $users,
            'roles' => $roles,
            'isSupervisor' => $isSupervisor,
        ]);
    }
}
