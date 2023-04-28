<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class ConfChat extends Component
{
    public $conversations;

    public ?Conversation $selectedConversation;

    public function mount(): void
    {
        $this->refreshConversations();
    }

    public function refreshConversations(): void
    {
        $this->conversations = Conversation::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.chat.conf-chat');
    }

    public function selectConversation(Conversation $conv): void
    {
        $this->selectedConversation = $conv;
    }
}
