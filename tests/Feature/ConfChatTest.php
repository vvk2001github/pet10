<?php

namespace Tests\Feature;

use App\Http\Livewire\Chat\ConfChat;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ConfChatTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

    // Создаем одно сообщение в беседе,
    // выделяем его, помещая в массив selectedMessages
    // и пробуем удалить методом deleteAllSelectedMessages.
    // Проверяем что сообщение пропало в списке всех сообщений в беседе.
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

    // Создаем беседу и 150 сообщений в ней.
    // Проверяем как отобразились кнопки пагинации.
    // Затем имитируем переход на страницу 3.
    // И снова проверяем логику отображения некоторых кнопок пагинации.
    public function test_pagination(): void
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

        for ($i = 0; $i < 150; $i++) {
            DB::table('messages')->insert([
                'sender_id' => $user->id,
                'conversation_id' => $conversation->id,
                'body' => $this->faker->text(100),
            ]);
        }

        Livewire::test(ConfChat::class)
            ->call('selectConversation', $conversation)
            ->assertSeeHtml('<button class="font-bold text-black btn btn-outline-secondary" wire:key="paginationPage-1">')
            ->assertSeeHtml('<button wire:click="paginationGoToPage(2)" wire:key="paginationPage-2" class="btn btn-outline-secondary">')
            ->assertSeeHtml('<button wire:click="paginationGoToPage(3)" wire:key="paginationPage-3" class="btn btn-outline-secondary">')
            ->assertSeeHtml('<button wire:click="paginationGoToPage(11)" wire:key="paginationPage-11" class="btn btn-outline-secondary">')
            ->call('paginationGoToPage', 3)
            ->assertSeeHtml('<button wire:click="paginationGoToPage(1)" wire:key="paginationPage-1" class="btn btn-outline-secondary">')
            ->assertSeeHtml('<button wire:click="paginationGoToPage(2)" wire:key="paginationPage-2" class="btn btn-outline-secondary">')
            ->assertSeeHtml('<button class="font-bold text-black btn btn-outline-secondary" wire:key="paginationPage-3">')
            ->assertSeeHtml('<button wire:click="paginationGoToPage(13)" wire:key="paginationPage-13" class="btn btn-outline-secondary">');
    }

    // Создаем сообщение в беседе,
    // пробуем симитировать изменение текста сообщения.
    // Проверяем что в списке сообщений новый текст,
    // а также проверяем что в базе изменился текст сообщения.
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
