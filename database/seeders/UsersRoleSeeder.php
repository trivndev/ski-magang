<?php

namespace Database\Seeders;

use App\Models\UsersRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'supervisor'
        ];

        foreach ($roles as $role){
            UsersRole::create([
               'role_name' => $role,
            ]);
        }
    }
}
