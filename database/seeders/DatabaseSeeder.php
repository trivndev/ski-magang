<?php

namespace Database\Seeders;

use App\Models\BookmarkedPost;
use App\Models\Internship;
use App\Models\LikedPost;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->call([
                EssentialSeeder::class,
            ]);
            return;
        }

        $this->call([
            UserSeeder::class,
            VocationalMajorSeeder::class,
            InternshipsPostStatusSeeder::class,
            InternshipSeeder::class,
            LikedPostSeeder::class,
            BookmarkedPostSeeder::class,
            RolePermissionSeeder::class,
            DashboardMetricSeeder::class,
        ]);

        $threeLatestInternships = Internship::query()
            ->with(['author', 'status'])
            ->withCount('likes')
            ->whereRelation('status', 'status', 'Approved')
            ->latest()->take(3)->get();

        foreach ($threeLatestInternships as $internship) {
            LikedPost::create([
                'user_id' => 1,
                'internship_id' => $internship->id,
            ]);
            BookmarkedPost::create([
                'user_id' => 1,
                'internship_id' => $internship->id,
            ]);
        }
    }
}
