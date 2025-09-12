<?php

namespace Database\Seeders;

use App\Models\VocationalMajor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VocationalMajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VocationalMajor::create([
            'major_name' => "TKJ",
        ]);
        VocationalMajor::create([
            'major_name' => "BID",
        ]);
        VocationalMajor::create([
            'major_name' => "AKL",
        ]);
    }
}
