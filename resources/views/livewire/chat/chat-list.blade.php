<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="chatlist_header">

        <div class="title">
            Chat
        </div>

        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->name}}" alt="">
        </div>
    </div>


    <div class="chatlist_body">

        @foreach ($conversations as $conversation)
        <div class="chatlist_item" wire:key='{{$conversation->id}}' wire:click="chatSelected({{$conversation->id}})">


            <div class="chatlist_info">
                <div class="top_row">
                    <div class="list_chatname">{{ $conversation->name }}
                    </div>
                    <span class="date">{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}</span>
                </div>

                <div class="bottom_row">

                    <div class="truncate message_body">
                        {{ $conversation->messages->last()?->body }}
                    </div>

                    @php
                        // $count_unread_messages = count($conversation->messages);
                        $last_readed_message_id = $conversation->last_readed_messages()->where('user_id', 1)->first()?->pivot->last_readed_message ?? 0;
                        $count_unread_messages = count($conversation->messages->where('id', '>', $last_readed_message_id));
                        // dd($count_unread_messages);
                        //$count_unread_messages =
                        echo '<div class="unread_count badge rounded-pill text-light bg-danger">'.$count_unread_messages.'</div>';
                    @endphp

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
