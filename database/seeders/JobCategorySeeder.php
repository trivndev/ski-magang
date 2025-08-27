<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Frontend Developer',
            'Backend Developer',
            'Fullstack Developer',
            'UI/UX Designer',
            'Accountant',
            'Marketing',
        ];

        foreach ($data as $category) {
            JobCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
