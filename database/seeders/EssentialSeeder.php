<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EssentialSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductionUserSeeder::class,
            RolePermissionSeeder::class,
            InternshipsPostStatusSeeder::class,
            VocationalMajorSeeder::class,
            DashboardMetricSeeder::class,
        ]);
    }
}
