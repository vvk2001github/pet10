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

                    <div class="message_body truncate">
                        {{ $conversation->descr }}
                    </div>

                    <div class="unread_count badge rounded-pill text-light bg-danger">56</div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
