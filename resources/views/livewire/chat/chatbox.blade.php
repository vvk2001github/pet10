<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @if ($selected_conversation)

    <div class="chatbox_header">

        <div class="return">
            <i class="bi bi-arrow-left"></i>
        </div>

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
                            @if ($message->created_at != $message->updated_at)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench fill-red-500" viewBox="0 0 16 16">
                                <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11l.471.242z"/>
                            </svg>
                            @endif
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

    <script>
        $(document).on('click','.return',function(){
            window.livewire.emit('resetComponent');
        });
    </script>

</div>
