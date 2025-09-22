<?php

namespace Database\Seeders;

use App\Models\InternshipsPostStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternshipsPostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
        [
            'status' => "Pending",
            'status_color' => "bg-blue-500",
        ],
        [
            'status' => "Approved",
            'status_color' => "bg-green-500",
        ],
        [
            'status' => "Rejected",
            'status_color' => "bg-red-500",
        ],
    ];
        foreach ($statuses as $status) {
            InternshipsPostStatus::create([
                'status' => $status['status'],
                'status_color' => $status['status_color'],
            ]);
        }
    }
}
