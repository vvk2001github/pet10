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
    use RefreshDatabase, WithFaker;

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
        app()->setLocale('ru');
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
            ->assertSeeHtml('Вы действительно хотете удалить пользователя '.$user_for_delete->name.'?');
    }

    public function test_select_edit_user()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);
        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $user_for_edit = User::factory()->create();
        Livewire::test(UserList::class)
            ->call('selectEditUser', $user_for_edit)
            ->assertSet('showList', false)
            ->assertSet('showEdit', true);
    }

    public function test_user_add()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);
        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $fake_name = $this->faker()->name();
        $fake_email = $this->faker()->email();
        Livewire::test(UserList::class)
            ->set('username', $fake_name)
            ->set('email', $fake_email)
            ->call('userAdd');

        $this->assertDatabaseHas('users', [
            'name' => $fake_name,
            'email' => $fake_email,
            'password' => '',
        ]);
    }

    public function test_user_save()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $roleConfigUsersId = Role::where('name', 'User Config')->get()->first()->id;
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $roleConfigChatId = Role::where('name', 'Chat Config')->get()->first()->id;
        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);
        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $user_for_edit = User::factory()->create();
        $user_for_edit->assignRole($roleConfigUsers);
        $old_name = $user_for_edit->name;
        $old_email = $user_for_edit->email;
        $fake_name = $this->faker()->name();
        $fake_email = $this->faker()->email();

        Livewire::test(UserList::class)
            ->set('showEdit', true)
            ->set('showList', false)
            ->set('selectedUser', $user_for_edit)
            ->set('editusername', $fake_name)
            ->set('editemail', $fake_email)
            ->set('editpassword', '123456')
            ->set('editpassword_confirmation', '123456')
            ->set('selectedRoles', ['Chat Config'])
            ->set('blocked', 0)
            ->call('userSave');

        $this->assertDatabaseMissing('users', [
            'name' => $old_name,
            'email' => $old_email,
        ])
            ->assertDatabaseHas('users', [
                'name' => $fake_name,
                'email' => $fake_email,
            ])
            ->assertDatabaseHas('model_has_roles', [
                'role_id' => $roleConfigChatId,
                'model_id' => $user_for_edit->id,
            ])
            ->assertDatabaseMissing('model_has_roles', [
                'role_id' => $roleConfigUsersId,
                'model_id' => $user_for_edit->id,
            ]);
    }

    public function test_regular_user_can_not_add_super_user_role()
    {
        $user = User::factory()->create();
        $roleConfigUsers = Role::create([
            'name' => 'User Config',
        ]);
        $roleConfigUsersId = Role::where('name', 'User Config')->get()->first()->id;

        $roleSuperUser = Role::create([
            'name' => 'Super User',
        ]);
        $roleSuperUserId = Role::where('name', 'Super User')->get()->first()->id;

        $permissionConfigUsers = Permission::create(['name' => 'configure.user']);
        $permissionConfigUsers->assignRole($roleConfigUsers);

        $user->assignRole($roleConfigUsers);
        $this->actingAs($user);

        $user_for_edit = User::factory()->create();
        $user_for_edit->assignRole($roleConfigUsers);
        $old_name = $user_for_edit->name;
        $old_email = $user_for_edit->email;
        $fake_name = $this->faker()->name();
        $fake_email = $this->faker()->email();

        Livewire::test(UserList::class)
            ->set('showEdit', true)
            ->set('showList', false)
            ->set('selectedUser', $user_for_edit)
            ->set('editusername', $fake_name)
            ->set('editemail', $fake_email)
            ->set('editpassword', '123456')
            ->set('editpassword_confirmation', '123456')
            ->set('selectedRoles', ['Super User'])
            ->call('userSave');

        // Проверим, что новые имя и почта в базе отсутствуют, осталиь старые
        // и не добавиась роль Супер Пользователя
        $this->assertDatabaseHas('users', [
            'name' => $old_name,
            'email' => $old_email,
        ])
            ->assertDatabaseMissing('users', [
                'name' => $fake_name,
                'email' => $fake_email,
            ])
            ->assertDatabaseMissing('model_has_roles', [
                'role_id' => $roleSuperUserId,
                'model_id' => $user_for_edit->id,
            ])
            ->assertDatabaseHas('model_has_roles', [
                'role_id' => $roleConfigUsersId,
                'model_id' => $user_for_edit->id,
            ]);
    }
}
