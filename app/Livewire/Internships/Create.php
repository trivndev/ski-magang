<?php

namespace App\Livewire\Internships;

use App\Models\Internship;
use App\Traits\HandlesInternshipsInteractions;
use App\Traits\WithQueryFilterAndSearch;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[layout('components.layouts.main-app')]
class Create extends Component
{
    use WithPagination, HandlesInternshipsInteractions, WithQueryFilterAndSearch;

    public function mount()
    {
        $this->initDraftFiltersFromUrl();
    }

    public function toggleLike(Internship $internshipId)
    {
        $this->likeInteraction($internshipId);
    }

    public function toggleBookmark(Internship $internshipId)
    {
        $this->bookmarkInteraction($internshipId);
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

        $query = Internship::query()
            ->with(['author', 'status'])
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
                'bookmarks as bookmarked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
            ])
            ->whereHas('author', fn($q) => $q->where('id', auth()->id()))
            ->whereRelation('status', 'status', 'Approved')
            ->where(function ($q) use ($fields, $keyword) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$keyword}%");
                }
            });

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
        ])->layoutData(['title' => "Internships create"]);
    }
}
