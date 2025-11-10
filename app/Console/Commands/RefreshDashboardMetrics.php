<?php

namespace App\Console\Commands;

use App\Services\DashboardMetricsService;
use Illuminate\Console\Command;

class RefreshDashboardMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:refresh-metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recompute and persist the dashboard metrics snapshot';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $metric = DashboardMetricsService::refresh();
        $this->info('Dashboard metrics refreshed at ' . $metric->snapshot_at);
        return self::SUCCESS;
    }
}
