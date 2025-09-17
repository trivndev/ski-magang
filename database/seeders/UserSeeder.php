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
        User::factory()->create([
            'name' => 'Nicolas',
            'email' => 'nicolas@gmail.com',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'role_id' => 2,
        ]);
        User::factory(100)->create();
    }
}
