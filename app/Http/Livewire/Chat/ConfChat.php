<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ConfChat extends Component
{
    public bool $allMessagesChecked = false;

    public ?\Illuminate\Database\Eloquent\Collection $conversations;

    public int $currentPage = 1;

    public bool $deleteConfirmationVisible = false;

    public bool $deleteAllMessageConfirmationVisible = false;

    public bool $editMessageWindowVisible = false;

    public int $lastPage = 1;

    public ?\Illuminate\Database\Eloquent\Collection $messages;

    public string $newBodyMessage = '';

    public int $paginationStep = 10;

    public ?Conversation $selectedConversation;

    public ?Message $selectedMessage;

    public array $selectedMessages = [];

    public function hideDeleteMessageConfirmation(): void
    {
        $this->selectedMessage = null;

        $this->deleteConfirmationVisible = false;
    }

    public function hideEditMessageWindow(): void
    {
        $this->selectedMessage = null;

        $this->editMessageWindowVisible = false;
    }

    public function deleteAllSelectedMessages(): void
    {
        $this->deleteAllMessageConfirmationVisible = false;

        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if (! $currentUser->can('configure.chat')) {
            return;
        }

        if (count($this->selectedMessages) == 0) {
            return;
        }

        Message::whereIn('id', $this->selectedMessages)->delete();

        $this->selectedMessages = [];

        $this->allMessagesChecked = false;
        $this->refreshConversations();
        $this->refreshMessages();

    }

    public function hideDeleteAllMessageConfirmation(): void
    {
        $this->deleteAllMessageConfirmationVisible = false;
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
            ->orderBy('id', 'DESC')
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

    public function saveSelectedMessage(): void
    {
        $this->editMessageWindowVisible = false;

        /** @var App\User $currentUser */
        $currentUser = auth()->user();
        if (! $currentUser->can('configure.chat')) {
            return;
        }

        $this->selectedMessage->body = $this->newBodyMessage;
        $this->selectedMessage->save();
        $this->selectedMessage = null;
        $this->refreshMessages();
    }

    public function selectConversation(Conversation $conv): void
    {
        $this->selectedConversation = $conv;
        $this->currentPage = 1;
        $this->refreshMessages();
    }

    public function showDeleteAllMessageConfirmation(): void
    {
        $this->deleteAllMessageConfirmationVisible = true;
    }

    public function showDeleteMessageConfirmation(Message $message): void
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->selectedMessage = $message;

        $this->deleteConfirmationVisible = true;
    }

    public function showEditMessageWindow(Message $message): void
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->selectedMessage = $message;
        $this->newBodyMessage = $this->selectedMessage->body;

        $this->editMessageWindowVisible = true;

        error_log($this->newBodyMessage);
    }

    public function updatedAllMessagesChecked(): void
    {
        $this->selectedMessages = [];

        foreach ($this->messages as $message) {
            array_push($this->selectedMessages, $message->id);
        }
    }

    public function updatedSelectedMessages(): void
    {
        error_log(implode(' ', $this->selectedMessages));
    }

    public function updatedPaginationStep()
    {
        $this->refreshMessages();
        $this->currentPage = 1;
        error_log($this->paginationStep);
    }
}
