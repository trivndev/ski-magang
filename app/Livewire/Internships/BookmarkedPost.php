<?php

namespace App\Livewire\Internships;

use App\Models\Internship;
use App\Traits\HandlesInternshipsInteractions;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[layout('components.layouts.main-app')]
class BookmarkedPost extends Component
{
    use WithPagination, HandlesInternshipsInteractions;

    public string $searchQuery = '';
    public array $selectedMajor = [];

    public string $sortBy = '';


    public function searchPost()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset();
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
            ->whereHas('bookmarks', fn($q) => $q->where('user_id', auth()->id()))
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

        return view('livewire.internships.bookmarked-post', [
            'internships' => $query->paginate(12),
        ])->layoutData(['title' => "Bookmarked Internships"]);
    }
}
