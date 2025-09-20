<?php

namespace Database\Seeders;

use App\Models\BookmarkedPost;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookmarkedPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $internships = Internship::all();

        foreach ($users as $user) {
            $likeCount = rand(1, 10);
            $selectedInternship = $internships->random($likeCount);

            foreach ($selectedInternship as $internship) {
                BookmarkedPost::create([
                    'user_id' => $user->id,
                    'internship_id' => $internship->id,
                ]);
            }
        }
    }
}
