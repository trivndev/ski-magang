<?php

namespace App\Livewire\Internships;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('components.layouts.main-app')]
class LikedPost extends Component
{
    public function render()
    {
        return view('livewire.internships.liked-post')->layoutData(['title' => "Liked Internships"]);
    }
}
