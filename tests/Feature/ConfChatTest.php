<?php

namespace Tests\Feature;

use App\Http\Livewire\Chat\ConfChat;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ConfChatTest extends TestCase
{
    use RefreshDatabase;

    // Создаём сообщение в беседе,
    // выбираем беседу и проверям,
    // видим ли мы в списке это сообщение.
    public function test_can_see_messages_in_conversation(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        $conversation = new Conversation([
            'user_id' => $user->id,
            'name' => 'Флудилка',
            'descr' => 'Разговоры обо всём',
        ]);
        $conversation->save();

        DB::table('messages')->insert([
            'sender_id' => $user->id,
            'conversation_id' => $conversation->id,
            'body' => 'Моё первое сообщение',
        ]);

        Livewire::test(ConfChat::class)
            ->call('selectConversation', $conversation)
            ->assertSee('Моё первое сообщение');
    }

    public function test_delete_all_selected_messages(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        $conversation = new Conversation([
            'user_id' => $user->id,
            'name' => 'Флудилка',
            'descr' => 'Разговоры обо всём',
        ]);
        $conversation->save();

        $message_id = DB::table('messages')->insertGetId([
            'sender_id' => $user->id,
            'conversation_id' => $conversation->id,
            'body' => 'Моё первое сообщение',
        ]);

        Livewire::test(ConfChat::class)
            ->call('selectConversation', $conversation)
            ->set('selectedMessages', [$message_id])
            ->call('deleteAllSelectedMessages')
            ->assertDontSee('Моё первое сообщение');
    }

    public function test_hide_delete_all_message_confirmation(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        Livewire::test(ConfChat::class)
            ->call('hideDeleteAllMessageConfirmation')
            ->assertDontSee(trans('Do you really want to delete all selected messages?'));
    }

    public function test_hide_delete_message_confirmation(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        Livewire::test(ConfChat::class)
            ->call('hideDeleteMessageConfirmation')
            ->assertSet('selectedMessage', null)
            ->assertSet('deleteConfirmationVisible', false)
            ->assertDontSee('Вы действительно хотете удалить сообщение от');
    }

    public function test_hide_edit_message_window(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        // $message

        Livewire::test(ConfChat::class)
            ->call('hideEditMessageWindow')
            ->assertSet('selectedMessage', null)
            ->assertSet('editMessageWindowVisible', false)
            ->assertDontSee(trans('Save'))
            ->assertDontSee('Enter text');
    }

    public function test_pagination(): void
    {
        //
    }

    public function test_Save_Selected_Message(): void
    {
        app()->setLocale('ru');
        $user = User::factory()->create();
        $roleConfigChat = Role::create([
            'name' => 'Chat Config',
        ]);
        $permissionConfigUsers = Permission::create(['name' => 'configure.chat']);
        $permissionConfigUsers->assignRole($roleConfigChat);
        $user->assignRole($roleConfigChat);
        $this->actingAs($user);

        $conversation = new Conversation([
            'user_id' => $user->id,
            'name' => 'Флудилка',
            'descr' => 'Разговоры обо всём',
        ]);
        $conversation->save();

        $message = new Message([
            'sender_id' => $user->id,
            'conversation_id' => $conversation->id,
            'body' => 'Моё первое сообщение',
        ]);
        $message->save();

        Livewire::test(ConfChat::class)
            ->call('selectConversation', $conversation)
            ->call('showEditMessageWindow', $message)
            ->set('newBodyMessage', 'Моё второе сообщение')
            ->call('saveSelectedMessage')
            ->assertDontSee('Моё первое сообщение')
            ->assertSee('Моё второе сообщение')
            ->assertSet('selectedMessage', null);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'body' => 'Моё второе сообщение',
        ]);
    }
}
