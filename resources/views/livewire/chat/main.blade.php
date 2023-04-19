<div>
    {{-- The Master doesn't talk, he acts. --}}


    <div class="chat_container">
        <div class="chat_list_container">
            @livewire('chat.chat-list')
        </div>

        <div class="chat_box_container">
            @livewire('chat.chatbox')
            @livewire('chat.send-message')
        </div>
    </div>
</div>
