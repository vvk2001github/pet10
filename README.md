Pet project with laravel 10 and jetstream, and livewire.

The chat is written using Pusher.
TODO List
Trello with livewire/sortable

It is possible to block users.

Test for chat.conf-chat component in tests\Feature\ConfChatTest.php
Test for user.user-list component in tests\Feature\UserListTest.php
Test for user.main component in tests\Feature\UserMainUserTest.php
Test for chat.main component in tests\Feature\ChatMainTest.php
Test for chat.sent-message component in tests\Feature\ChatSendMessageTest.php

Docker install:
- php artisan storage:link
- php artisan migrate 
or php artisan migrate:fresh --seed
