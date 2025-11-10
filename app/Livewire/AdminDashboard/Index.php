<?php

namespace App\Livewire\AdminDashboard;

use App\Models\DashboardMetric;
use App\Services\DashboardMetricsService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin'), Title('Admin Dashboard')]
class Index extends Component
{
    public function render()
    {
        // Load latest cached metrics; if none, compute once
        $metric = DashboardMetric::query()->latest('snapshot_at')->first();
        if (!$metric) {
            $metric = DashboardMetricsService::refresh();
        }

        return view('livewire.admin-dashboard.index', [
            'metric' => $metric,
        ]);
    }
}
