<?php

namespace Database\Seeders;

use App\Models\BookmarkedPost;
use App\Models\Internship;
use App\Models\LikedPost;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersRoleSeeder::class,
            UserSeeder::class,
            JobCategorySeeder::class,
            VocationalMajorSeeder::class,
            InternshipSeeder::class,
            LikedPostSeeder::class,
            BookmarkedPostSeeder::class,
        ]);
        $threeLatestInternships = Internship::latest()->take(3)->get();;
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
