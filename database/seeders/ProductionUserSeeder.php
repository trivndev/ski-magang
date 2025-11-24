<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Nicolas',
            'email' => 'nicolas100107@gmail.com',
            'password' => Hash::make('HelloWorld'),
        ]);
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
        ]);
        User::factory()->create([
            'name' => 'normal user',
            'email' => 'user@example.com',
        ]);
    }
}
