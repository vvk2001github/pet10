<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $selected_conversation = null;

    public function chatSelected(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $this->emitTo('chat.chatbox', 'loadConversation', $this->selected_conversation);
    }

    public function mount()
    {

        $this->auth_id = auth()->id();
        $this->conversations = Conversation::orderBy('name', 'ASC')->get();

    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }

    public function resetComponent()
    {
        $this->selected_conversation = null;
    }
}
