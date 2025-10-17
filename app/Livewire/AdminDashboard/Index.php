<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard.index')->layoutData([
            'title' => 'Admin Dashboard',
        ]);
    }
}
