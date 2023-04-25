<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    public function test_userlist_display_roles(): void
    {
        $user = User::factory()->create();

        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);

        $permissionConfigChat = Permission::create(['name' => 'configure.chat']);
        $permissionConfigChat->assignRole($roleConfigChat);
        $user->assignRole('Chat Config');

        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);

        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);

        $user->assignRole($roleConfigUsers);

        $this->actingAs($user);

        $this->get('/confuser')
            ->assertSeeText('Chat Config, User Config');
    }
}
