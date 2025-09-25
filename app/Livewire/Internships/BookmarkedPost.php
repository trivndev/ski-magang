<?php

namespace App\Livewire\Internships;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('components.layouts.main-app')]
class BookmarkedPost extends Component
{
    public function render()
    {
    return view('livewire.internships.bookmarked-post')->layoutData(['title' => "Bookmarked Internships"]);
    }
}
