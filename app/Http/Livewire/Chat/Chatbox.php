<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chatbox extends Component
{

    public $height;
    public $selected_conversation = null;
    public $messages;
    public $paginateVar = 10;

    protected $listeners = [
        'loadConversation' => 'loadConversation',
        'loadmore' => 'loadmore',
        'updateHeight' => 'updateHeight',
    ];

    public function loadConversation(Conversation $conversation)
    {
        $this->selected_conversation = $conversation;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();
        $this->messages = Message::where('conversation_id',  $this->selected_conversation->id)
            ->skip($messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $this->dispatchBrowserEvent('rowChatToBottom');
    }

    function loadmore()
    {

        // dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $messages_count = Message::where('conversation_id', $this->selected_conversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selected_conversation->id)
            ->skip($messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
        # code...
    }

    public function mount()
    {
        $this->loadConversation(Conversation::find(1));
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }

    function updateHeight($height)
    {
        $this->height = $height;
    }
}
