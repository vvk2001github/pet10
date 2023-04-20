<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{

    public $body;
    public Message $createdMessage;
    public ?Conversation $selected_conversation = null;

    protected $listeners = [
        'updateSendMessage',
        'dispatchMessageSent',
        'resetComponent',
    ];

    public function dispatchMessageSent()
    {
        // error_log('dispatchMessageSent');
        broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selected_conversation));
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }

    public function resetComponent()
    {
        $this->selected_conversation = null;
    }

    public function sendMessage()
    {
        if ($this->body == null) return null;

        $this->createdMessage = Message::create([
            'sender_id' => auth()->id(),
            'conversation_id' => $this->selected_conversation->id,
            'body' => $this->body,
        ]);

        $this->selected_conversation->last_time_messages = $this->createdMessage->created_at;
        $this->selected_conversation->save();
        $this->emitTo('chat.chatbox', 'pushMessage', $this->createdMessage->id);

        $this->emitTo('chat.chat-list', 'refresh');
        $this->reset('body');

        $this->emitSelf('dispatchMessageSent');
    }

    public function updateSendMessage(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
    }
}
