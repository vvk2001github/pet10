<?php

namespace Tests\Feature;

use App\Http\Livewire\Chat\SendMessage;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class ChatSendMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_message(): void{

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->actingAs($user);

        DB::table('conversations')->insert([
            'user_id' => 1,
            'name' => 'Флудилка',
            'descr' => 'Разговоры обо всём',
        ]);

        $conversation = new Conversation();
        $conversation->user_id = $user->id;
        $conversation->name = 'C1';
        $conversation->descr = 'descr';
        $conversation->save();



        Livewire::test(SendMessage::class)
            ->set('selected_conversation', $conversation)
            ->set('body', 'test')
            ->call('sendMessage')
            ->assertEmittedTo('chat.chatbox', 'pushMessage')
            ->assertEmittedTo('chat.chat-list', 'refresh')
            ->assertEmitted('dispatchMessageSent');

            $this->assertDatabaseHas('messages', [
                'body' => 'test',
            ]);

    }
}
