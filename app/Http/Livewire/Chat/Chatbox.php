<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use Livewire\Component;

class Chatbox extends Component
{

    public $height;
    public $selected_conversation = null;
    public $messages;
    public $paginateVar = 10;

    // protected $listeners = [
    //     'loadConversation',
    //     'loadmore',
    //     'updateHeight',
    //     'resetComponent',
    //     'pushMessage'
    // ];

    public function broadcastedMessageReceived($event)
    {
        $broadcastedMessage = Message::find($event['message']);
        // error_log($broadcastedMessage);
        if($broadcastedMessage->sender_id != auth()->user()->id || $broadcastedMessage->conversation_id != $this->selected_conversation?->id) {
            $this->emitTo('chat.chat-list','refresh');
        } else {
            //
        }
    }

    public function getListeners(): array
    {
        return [
            "echo-private:pet10.chat.MessageSent,MessageSent" => 'broadcastedMessageReceived',
            // "echo-private:chat.{$selected_conversation},MessageRead" => 'broadcastedMessageRead',
            'loadConversation',
            'loadmore',
            'updateHeight',
            'resetComponent',
            'pushMessage'
        ];
    }

    public function loadConversation(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();
        // error_log('Message count:'.$messages_count);
        // error_log('selected_conversation:'.$this->selected_conversation->id);
        $this->messages = Message::where('conversation_id',  $this->selected_conversation->id)
            ->orderBy('created_at', 'ASC')
            ->skip($messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        // error_log($this->messages);

        $this->dispatchBrowserEvent('rowChatToBottom');
        $this->dispatchBrowserEvent('chatSelected');
    }

    function loadmore()
    {

        // dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selected_conversation->id)
            ->orderBy('created_at', 'ASC')
            ->skip($messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
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
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }

    public function resetComponent()
    {
        $this->selected_conversation= null;
    }

    function updateHeight($height)
    {
        $this->height = $height;
    }
}
