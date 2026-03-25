<?php

namespace Database\Seeders;

use App\Models\Internship;
use App\Models\InternshipPostStatus;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\VocationalMajor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $internships = Internship::factory(1000)->recycle([
                User::all(),
                VocationalMajor::all(),
            ])->create();
        }
    }
}
