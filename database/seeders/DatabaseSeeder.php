<?php

namespace Database\Seeders;

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
    }
}
