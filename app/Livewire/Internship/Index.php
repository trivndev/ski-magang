<?php

namespace App\Livewire\Internship;

use App\Models\Internship;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('components.layouts.main-app')]
class Index extends Component
{
    #[computed()]
    public function selectedInternship()
    {
        $jobId = request()->query('jobId');
        if ($jobId) {
            return Internship::find($jobId);
        }
        return null;
    }

    #[computed()]
    public function internships()
    {
        return Internship::latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.internship.index');
    }
}
