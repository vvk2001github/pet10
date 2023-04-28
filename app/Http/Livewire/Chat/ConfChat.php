<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ConfChat extends Component
{
    public ?\Illuminate\Database\Eloquent\Collection $conversations;

    public int $currentPage = 1;

    public bool $deleteConfirmationVisible = false;

    public int $lastPage = 1;

    public ?\Illuminate\Database\Eloquent\Collection $messages;

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

    public function paginationGoToFirstPage(): void
    {
        $this->currentPage = 1;
        $this->refreshMessages();
    }

    public function paginationGoToLastPage(): void
    {
        $this->currentPage = $this->lastPage;
        $this->refreshMessages();
    }

    public function paginationGoToPage(int $page): void
    {
        $this->currentPage = $page;
        $this->refreshMessages();
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
            ->skip($this->paginationStep * ($this->currentPage - 1))
            ->take($this->paginationStep)
            ->get();

        $this->lastPage = intdiv($this->selectedConversation->messages()->count(), $this->paginationStep);

        if ($this->selectedConversation->messages()->count() % $this->paginationStep != 0) {
            $this->lastPage += 1;
        }
    }

    public function render()
    {
        return view('livewire.chat.conf-chat');
    }

    public function selectConversation(Conversation $conv): void
    {
        $this->selectedConversation = $conv;
        $this->currentPage = 1;
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

    public function updatedPaginationStep()
    {
        $this->refreshMessages();
        $this->currentPage = 1;
        error_log($this->paginationStep);
    }
}
