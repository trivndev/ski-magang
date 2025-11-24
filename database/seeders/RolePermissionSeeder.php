<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage post',
            'manage user',
            'manage role',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin->syncPermissions([$permissions[0], $permissions[1]]);
        $supervisor->syncPermissions($permissions);

        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->syncRoles([$admin]);
        }

        $supervisorUser = User::where('email', 'nicolas100107@gmail.com')->first();
        if ($supervisorUser) {
            $supervisorUser->syncRoles([$supervisor]);
        }

        $defaultUsers = User::whereNotIn('email', ['admin@example.com', 'nicolas100107@gmail.com'])->get();
        foreach ($defaultUsers as $user) {
            if ($user->roles()->count() === 0) {
                $user->assignRole($userRole);
            }
        }
    }
}
