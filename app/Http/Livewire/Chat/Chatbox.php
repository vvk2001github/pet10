<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatbox extends Component
{
    public $height;

    public $selected_conversation = null;

    public $messages;

    public $paginateVar = 10;

    public function broadcastedMessageReceived($event)
    {
        $broadcastedMessage = Message::find($event['message']);

        if ($this->selected_conversation && $broadcastedMessage->sender_id != auth()->user()->id && $broadcastedMessage->conversation_id == $this->selected_conversation->id) {
            $this->pushMessage($broadcastedMessage);
        }

        $this->emitTo('chat.chat-list', 'refresh');
    }

    public function getListeners(): array
    {
        return [
            'echo-private:pet10.chat.MessageSent,MessageSent' => 'broadcastedMessageReceived',
            // "echo-private:chat.{$selected_conversation},MessageRead" => 'broadcastedMessageRead',
            'loadConversation',
            'loadmore',
            'updateHeight',
            'resetComponent',
            'pushMessage',
            'makeConversationAsRead',
        ];
    }

    public function loadConversation(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)
            ->orderBy('created_at', 'ASC')
            ->skip($messages_count - $this->paginateVar)
            ->take($this->paginateVar)->get();

        // error_log($this->messages);

        $this->emitSelf('makeConversationAsRead');
        $this->dispatchBrowserEvent('rowChatToBottom');
        $this->dispatchBrowserEvent('chatSelected');
    }

    public function loadmore()
    {

        // dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)
            ->orderBy('created_at', 'ASC')
            ->skip($messages_count - $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function makeConversationAsRead()
    {
        $oldest_message = $this->selected_conversation->messages->sortBy('created_at')->last() ?? null;
        $user_id = auth()->user()->id;
        if ($oldest_message) {
            $id_oldest_message = $oldest_message->id;
            $last_readed_message = $this->selected_conversation->last_readed_messages()->where('user_id', Auth::user()->id)->first()?->pivot->last_readed_message ?? 0;
            if ($last_readed_message == 0) {
                $this->selected_conversation->last_readed_messages()->attach($user_id, ['last_readed_message' => $id_oldest_message]);
            } else {
                $this->selected_conversation->last_readed_messages()->updateExistingPivot($user_id, ['last_readed_message' => $id_oldest_message]);
            }
        }
        $this->emitTo('chat.chat-list', 'refresh');
    }

    public function mount()
    {
        // $this->loadConversation(Conversation::find(1));
    }

    // Добавляем собственное сообщение вниз списка сообщений
    public function pushMessage(Message $message)
    {
        $this->messages->push($message);
        $this->dispatchBrowserEvent('rowChatToBottom');
        $this->makeConversationAsRead();
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }

    public function resetComponent()
    {
        $this->selected_conversation = null;
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }
}
