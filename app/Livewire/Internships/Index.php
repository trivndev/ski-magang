<?php

namespace App\Livewire\Internships;

use App\Models\Internship;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('components.layouts.main-app')]
class Index extends Component
{
    #[Computed()]
    public function internships()
    {
        return Internship::query()
            ->with(['author', 'status'])
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
                'bookmarks as bookmarked_by_me' => fn($q) => $q->where('user_id', auth()->id()),
            ])
            ->whereRelation('status', 'status', 'Approved')
            ->latest()
            ->paginate(12);
    }

    public function likeInternship(Internship $internship)
    {

    }

    public function unlikeInternship(Internship $internship)
    {

    }

    public function bookmarkInternship(Internship $internship)
    {

    }

    public function deleteInternship(Internship $internship)
    {

    }

    public function render()
    {
        return view('livewire.internships.index')->layoutData(['title' => "Internships information"]);
    }
}
