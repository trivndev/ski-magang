<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\DashboardMetricsService;

class DashboardMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate a fresh dashboard metrics snapshot based on current seeded data
        DashboardMetricsService::refresh();
    }
}
