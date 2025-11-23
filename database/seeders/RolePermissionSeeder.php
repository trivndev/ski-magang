<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        foreach (User::whereNotIn('id', [1, 2])->get() as $user) {
            $user->assignRole($userRole);
        }

        if ($supervisorUser = User::find(1)) {
            $supervisorUser->assignRole($supervisor);
        }

        if ($adminUser = User::find(2)) {
            $adminUser->assignRole($admin);
        }
    }
}
