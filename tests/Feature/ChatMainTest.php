<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatMainTest extends TestCase
{
    public function test_unregister_user_cannot_see_chat_components():void
    {
        $this->get('/chat')->assertDontSeeLivewire('chat.chat-list');
    }

    public function test_main_chat_contains_components():void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->get('/chat')->assertSeeLivewire('chat.chat-list');
        $this->get('/chat')->assertSeeLivewire('chat.chatbox');
        $this->get('/chat')->assertSeeLivewire('chat.send-message');
    }
}
