<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);

        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);

        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigChat = Permission::create(['name' => 'configure.chat']);

        $permissionConfigUsers->assignRole($roleConfigUsers);
        $permissionConfigChat->assignRole($roleConfigChat);

        User::where('email', 'nastya@example.com')->first()->assignRole('Chat Config');
    }
}
