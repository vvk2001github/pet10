<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="chatbox_header">

        <div class="return">
            <i class="bi bi-arrow-left"></i>
        </div>

        <div class="img_container">
            <img src="https://ui-avatars.com/api/?name=name" alt="">
        </div>

        <div class="name">
            John
        </div>

        <div class="info">
            <div class="info_item">
                <i class="bi bi-telephone-fill"></i>
            </div>

            <div class="info_item">
                <i class="bi bi-image"></i>
            </div>

            <div class="info_item">
                <i class="bi bi-info-circle-fill"></i>
            </div>
        </div>
    </div>

    <div class="chatbox_body">

            @foreach ($messages as $message)

            <div class="msg_body {{ auth()->id() == $message->sender->id ? 'msg_body_me' : 'msg_body_receiver' }}" style="width:80%;max-width:80%;max-width:max-content">
                <div class="name text-black">
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
</div>
