<?php

namespace Tests\Feature;

use App\Http\Livewire\User\UserList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use RefreshDatabase;


    // Проверяем правильность отображения ролей в списке пользователей
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

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);
        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $user_for_delete = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'name' => $user_for_delete->name,
        ]);

        Livewire::test(UserList::class)
            ->set('selectedUser', $user_for_delete)
            ->call('deleteUser')
            ->assertEmitted('showUserList')
            ->assertEmitted('refreshUsers');

        $this->assertDatabaseMissing('users', [
            'name' => $user_for_delete->name,
        ]);
    }

    public function test_remove_all_roles()
    {
        Livewire::test(UserList::class)
            ->set('selectedRoles', ['qwerty', 'qwert'])
            ->call('removeAllRoles')
            ->assertSet('selectedRoles', []);
    }

    public function test_select_delete_user()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);
        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $user_for_delete = User::factory()->create();

        Livewire::test(UserList::class)
            ->call('selectDeleteUser', $user_for_delete)
            ->assertSeeHtml("Do you really want to delete the user ".$user_for_delete->name."?");
    }
}
