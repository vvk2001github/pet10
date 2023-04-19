<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chatbox extends Component
{

    public $selected_conversation = null;
    public $messages;

    protected $listeners = ['loadConversation' => 'loadConversation'];

    public function loadConversation(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $this->messages = Message::where('conversation_id',  $this->selected_conversation->id)->get();
    }

    public function mount()
    {
        $this->loadConversation(Conversation::find(1));
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
