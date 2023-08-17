<?php

namespace Tests\Feature;

use App\Http\Livewire\User\UserList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserMainUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboar_permissions(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();

        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);

        $permissionConfigChat = Permission::create(['name' => 'configure.chat']);
        $permissionConfigChat->assignRole($roleConfigChat);
        $user->assignRole('Chat Config');

        $this->actingAs($user);

        $this->get('/dashboard')
            ->assertSeeText('Настроить Чат');
    }

    public function test_main_user_component_unauthorized(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/confuser')
            ->assertForbidden();
    }

    public function test_main_user_component_authorized(): void
    {
        $user = User::factory()->create();

        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);

        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);

        $user->assignRole($roleConfigUsers);

        $this->actingAs($user);

        $this->get('/confuser')
            ->assertSeeLivewire(UserList::class);
    }
}
