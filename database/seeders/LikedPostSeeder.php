<?php

namespace Database\Seeders;

use App\Models\Internship;
use App\Models\LikedPost;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikedPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LikedPost::factory(50)->recycle([
            User::all(),
            Internship::all()
        ])->create();
    }
}
