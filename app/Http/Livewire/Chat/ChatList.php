<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class ChatList extends Component
{
    public \Illuminate\Support\Collection $conversations;
    public ?Conversation $selected_conversation = null;

    protected $listeners= ['chatSelected','refresh'=>'$refresh','resetComponent'];

    public function chatSelected(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $this->emitTo('chat.chatbox', 'loadConversation', $this->selected_conversation);
        $this->emitTo('chat.send-message', 'updateSendMessage', $this->selected_conversation);
    }

    public function mount()
    {

        $this->conversations = Conversation::orderBy('name', 'ASC')->get();

    }

    public function render():\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.chat.chat-list');
    }

    public function resetComponent()
    {
        $this->selected_conversation = null;
    }
}
