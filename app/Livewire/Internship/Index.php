<?php

namespace App\Livewire\Internship;

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
            ->with(['jobCategory', 'author', 'status'])
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => fn ($q) => $q->where('user_id', auth()->id()),
            ])
            ->whereRelation('status', 'status', 'Approved')
            ->latest()
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.internship.index');
    }
}
