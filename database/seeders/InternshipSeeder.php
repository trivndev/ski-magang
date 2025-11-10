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
        $internships = Internship::factory(1000)->recycle([
            User::all(),
            VocationalMajor::all(),
        ])->create();

        // Soft delete a small random subset so the dashboard "Deleted Posts" shows data
        $toDelete = $internships->random(max(10, (int) floor($internships->count() * 0.08))); // ~8%
        foreach ($toDelete as $post) {
            // pick a deleted_at between created_at and now
            $deletedAt = fake()->dateTimeBetween($post->created_at, 'now');
            $post->deleted_at = $deletedAt;
            $post->saveQuietly();
        }
    }
}
