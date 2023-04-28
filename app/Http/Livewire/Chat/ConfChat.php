<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ConfChat extends Component
{
    public ?\Illuminate\Database\Eloquent\Collection $conversations;

    public bool $deleteConfirmationVisible = false;

    public ?\Illuminate\Database\Eloquent\Collection $messages;

    public int $paginationSkip = 0;

    public int $paginationStep = 10;

    public ?Conversation $selectedConversation;

    public ?Message $selectedMessage;

    public function hideDeleteMessageConfirmation(): void
    {
        $this->selectedMessage = null;

        $this->deleteConfirmationVisible = false;
    }

    public function mount(): void
    {
        $this->refreshConversations();
    }

    public function refreshConversations(): void
    {
        $this->conversations = Conversation::orderBy('name')->get();
    }

    public function refreshMessages(): void
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->messages = $this->selectedConversation->messages()
            ->orderBy('created_at', 'DESC')
            ->skip($this->paginationSkip)
            ->take($this->paginationStep)
            ->get();
    }

    public function render()
    {
        return view('livewire.chat.conf-chat');
    }

    public function selectConversation(Conversation $conv): void
    {
        $this->selectedConversation = $conv;
        $this->refreshMessages();
    }

    public function showDeleteMessageConfirmation(Message $message): void
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->selectedMessage = $message;

        $this->deleteConfirmationVisible = true;
    }
}
