<?php

namespace App\Livewire\Internships;

use App\Livewire\Internships\Forms\InternshipForm;
use App\Models\Internship;
use App\Traits\HandlesInternshipsInteractions;
use App\Traits\WithNotify;
use App\Traits\WithQueryFilterAndSearch;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[layout('components.layouts.main-app'), Title('Create Post | SKI MAGANG')]
class Create extends Component
{
    use WithPagination, WithFileUploads, HandlesInternshipsInteractions, WithQueryFilterAndSearch, WithNotify;

    public InternshipForm $internshipForm;

    public array $selected = [];
    public bool $selectMode = false;

    #[Url(as: 'statuses', except: [])]
    public array $selectedStatus = [];
    public array $draftSelectedStatus = [];

    protected function initDraftFiltersFromUrlExtra(): void
    {
        $this->draftSelectedStatus = $this->selectedStatus;
    }

    protected function applyDraftsToUrlStateExtra(): void
    {
        $this->selectedStatus = $this->draftSelectedStatus;
    }

    protected function clearFiltersExtra(): void
    {
        $this->selectedStatus = [];
        $this->draftSelectedStatus = [];
    }

    public function mount()
    {
        $this->initDraftFiltersFromUrl();
    }

    public function toggleLike($internshipId)
    {
        $this->likeInteraction($internshipId);
    }

    public function toggleBookmark($internshipId)
    {
        $this->bookmarkInteraction($internshipId);
    }

    public function bulkDelete(): void
    {
        if (empty($this->selected)) return;

        try {
            $bannedId = \App\Models\InternshipsPostStatus::query()
                ->whereRaw('LOWER(status) = ?', ['banned'])
                ->value('id');
            $deletedId = \App\Models\InternshipsPostStatus::query()
                ->whereRaw('LOWER(status) = ?', ['deleted'])
                ->value('id');

            $items = Internship::query()
                ->whereIn('id', $this->selected)
                ->where('author_id', auth()->id())
                ->get();

            $skipped = 0;
            $deletedCount = 0;

            foreach ($items as $item) {
                if ($bannedId && (string)$item->status_id === (string)$bannedId) {
                    $skipped++;
                    continue;
                }

                if ($deletedId) {
                    $item->status_id = $deletedId;
                    $item->save();
                }

                $item->delete();
                $deletedCount++;
            }

            $this->selected = [];

            if ($deletedCount > 0) {
                $msg = $skipped > 0
                    ? "Deleted {$deletedCount} post(s). {$skipped} banned post(s) were skipped."
                    : "Deleted {$deletedCount} post(s).";
                $this->notifySuccess('Bulk Delete', $msg);
            }

            if ($deletedCount === 0 && $skipped > 0) {
                $this->notifyError('Bulk Delete', 'All selected posts are banned and cannot be deleted.');
            }
        } catch (\Throwable $e) {
            $this->notifyError('Bulk Delete Failed', $e->getMessage() ?: 'Unable to delete selected posts.');
        }
    }

    public function createPost()
    {
        $this->internshipForm->store();

        $this->notifySuccess('Create Post', 'Post has been created.');
    }

    public function loadForEdit(string $internshipId): void
    {
        $internship = Internship::query()
            ->whereKey($internshipId)
            ->where('author_id', auth()->id())
            ->firstOrFail();

        $this->internshipForm->job_title = $internship->job_title;
        $this->internshipForm->company = $internship->company;
        $this->internshipForm->company_logo = null;
        $this->internshipForm->existing_company_logo = $internship->company_logo;
        $this->internshipForm->location = $internship->location;
        $this->internshipForm->job_description = $internship->job_description;
        $this->internshipForm->requirements = $internship->requirements;
        $this->internshipForm->benefits = (string)$internship->benefits;
        $this->internshipForm->contact_email = (string)$internship->contact_email;
        // Prefill phone to match UI prefix (+628). Show only the subscriber part in the input.
        $rawPhone = (string)$internship->contact_phone;
        $compact = str_replace([' ', '(', ')', '-', '.'], '', $rawPhone);
        if (str_starts_with($compact, '+628')) {
            $displayPhone = substr($compact, 4);
        } elseif (str_starts_with($compact, '628')) {
            $displayPhone = substr($compact, 3);
        } elseif (str_starts_with($compact, '08')) {
            $displayPhone = substr($compact, 2);
        } elseif (str_starts_with($compact, '8')) {
            $displayPhone = $compact;
        } else {
            $displayPhone = $rawPhone;
        }
        $this->internshipForm->contact_phone = $displayPhone;
        $this->internshipForm->contact_name = $internship->contact_name;
        // Prefill end_date in HTML <input type="date"> compatible format (Y-m-d)
        $this->internshipForm->end_date = $internship->end_date
            ? \Carbon\Carbon::parse($internship->end_date)->format('Y-m-d')
            : '';
        $this->internshipForm->vocational_major_id = $internship->vocational_major_id;
    }

    public function updatePost(string $internshipId): void
    {
        try {
            $this->internshipForm->update($internshipId);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $first = is_array($errors) ? collect($errors)->flatten()->first() : null;
            $message = $first ?: 'Validation failed. Please review the highlighted fields.';
            $this->notifyError('Update Post Failed', $message);
            throw $e;
        } catch (\Throwable $e) {
            $message = $e->getMessage() ?: 'Unable to update the post due to an unexpected error.';
            $this->notifyError('Update Post Failed', $message);
            return;
        }

        $this->dispatch('modal-close', name: 'edit-internship-' . $internshipId);

        $this->notifySuccess('Update Post', 'Post has been updated and is now pending approval.');
    }

    public function deletePost(string $internshipId): void
    {
        try {
            $internship = Internship::query()
                ->whereKey($internshipId)
                ->where('author_id', auth()->id())
                ->firstOrFail();

            $bannedId = \App\Models\InternshipsPostStatus::query()
                ->whereRaw('LOWER(status) = ?', ['banned'])
                ->value('id');

            if ($bannedId && (string)$internship->status_id === (string)$bannedId) {
                $this->notifyError('Delete Post Failed', 'This post is banned and cannot be deleted.');
                return;
            }

            $deletedId = \App\Models\InternshipsPostStatus::query()
                ->whereRaw('LOWER(status) = ?', ['deleted'])
                ->value('id');
            if ($deletedId) {
                $internship->status_id = $deletedId;
                $internship->save();
            }

            $internship->delete();

        } catch (\Throwable $e) {
            $this->notifyError('Delete Post Failed', $e->getMessage() ?: 'Unable to delete this post.');
            return;
        }

        $this->dispatch('modal-close', name: 'delete-internship-' . $internshipId);
        $this->dispatch('modal-close', name: 'internship-' . $internshipId);

        $this->notifySuccess('Delete Post', 'Post has been deleted.');
    }

    public function render()
    {
        $fields = [
            'job_title',
            'company',
            'location',
        ];
        $keyword = $this->searchQuery;
        $selectedMajor = $this->selectedMajor;
        $selectedStatus = $this->selectedStatus;

        $query = Internship::query()
            ->withTrashed()
            ->with(['author', 'status'])
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
                'bookmarks as bookmarked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
            ])
            ->whereHas('author', fn($q) => $q->where('id', auth()->id()))
            ->where(function ($q) use ($fields, $keyword) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$keyword}%");
                }
            });

        if (!empty($selectedStatus)) {
            $query->whereHas('status', fn($q) => $q->whereIn('status', $selectedStatus));
        }

        if (!empty($selectedMajor)) {
            $query->whereIn('vocational_major_id', $selectedMajor);
        }

        switch ($this->sortBy) {
            case 'likes':
                $query->orderByDesc('likes_count');
                break;
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }
        return view('livewire.internships.create', [
            'internships' => $query->paginate(12),
        ]);
    }
}
