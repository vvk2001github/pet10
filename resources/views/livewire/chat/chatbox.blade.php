<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @if ($selected_conversation)

    <div class="chatbox_header">

        <div class="name">
            {{ $selected_conversation->descr }}
        </div>

    </div>

    <div class="chatbox_body">

            @foreach ($messages as $message)

            <div class="msg_body {{ auth()->id() == $message->sender->id ? 'msg_body_me' : 'msg_body_receiver' }}" style="width:80%;max-width:80%;max-width:max-content">
                <div class="text-black name">
                    {{ $message->sender->name }}
                </div>
                {{ $message->body }}
                <div class="msg_body_footer">
                    <div class="date">
                        {{ $message->created_at->format('Y-m-d H:i') }}
                    </div>

                    <div class="read">
                        <div class="read">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

    </div>

    <div class="chatbox_footer">
        footer
    </div>

    @else

        <div class="mt-5 text-center fs-4 text-primary">
            No conversasion selected
        </div>

    @endif

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        $(".chatbox_body").on('scroll', function() {
            // alert('aahsd');
            var top = $('.chatbox_body').scrollTop();
            //   alert('aasd');
            if (top == 0) {
                window.livewire.emit('loadmore');
            }
        });
    </script>

    <script>
        window.addEventListener('updatedHeight', event => {
            let old = event.detail.height;
            let newHeight = $('.chatbox_body')[0].scrollHeight;
            let height = $('.chatbox_body').scrollTop(newHeight - old);
            window.livewire.emit('updateHeight', {
                height: height,
            });
        });
    </script>

    <script>
        window.addEventListener('rowChatToBottom', event => {
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
        });
    </script>

</div>
