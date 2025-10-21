<?php

namespace App\Livewire\Internships;

use App\Livewire\Internships\Forms\InternshipForm;
use App\Models\Internship;
use App\Traits\HandlesInternshipsInteractions;
use App\Traits\WithQueryFilterAndSearch;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[layout('components.layouts.main-app'), Title('Create Post | SKI MAGANG')]
class Create extends Component
{
    use WithPagination, HandlesInternshipsInteractions, WithQueryFilterAndSearch;

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

        Internship::whereIn('id', $this->selected)
            ->where('author_id', auth()->id())
            ->delete();

        $this->selected = [];
    }

    public function createPost()
    {
        $this->internshipForm->store();

        session()->flash('success', 'Internship created successfully.');
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
