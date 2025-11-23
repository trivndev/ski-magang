<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = fake()->dateTimeBetween('-11 months', 'now');
        User::factory()->create([
            'name' => 'Nicolas',
            'email' => 'nicolas@gmail.com',
            'created_at' => $created,
            'updated_at' => $created,
        ]);
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'created_at' => $created,
            'updated_at' => $created,
        ]);
        User::factory()->create([
            'name' => 'normal user',
            'email' => 'user@gmail.com',
            'created_at' => $created,
            'updated_at' => $created,
        ]);
        User::factory(100)->create();
    }
}
