<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Configure Chat')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="gap-6 p-6 bg-gray-200 bg-opacity-25 lg:gap-8 lg:p-8 columns-1" >
                    <div class="container mx-auto">

                        @if($conversations)
                        <div class="mx-auto">
                            <table class="w-full border-b table-fixed border-x">
                                <caption class="caption-top">
                                    {{__('Conversation List')}}
                                </caption>
                                <thead>
                                    <tr>
                                    <th class="p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Name')}}</th>
                                    <th class="p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Message Count')}}</th>
                                    <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border border-black">{{__('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($conversations as $conversation)
                                        <tr wire:click="selectConversation({{ $conversation }})" class="odd:bg-gray-100 hover:!bg-stone-200 cursor-pointer">
                                            <td class="p-2 text-left border-b border-l">{{ $conversation->name }}</td>
                                            <td class="p-2 text-left border-b border-l">{{ $conversation->messages->count() }}</td>

                                            <td class="p-2 text-left border-b border-l">
                                                <i class="bi bi-gear-fill hover:text-red-900" wire:key="conversationEdit-{{$conversation->id}}"></i>
                                                <i class="bi bi-trash-fill hover:text-red-900" wire:key="conversationDelete-{{$conversation->id}}"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if($selectedConversation)
                        <div class="grid grid-cols-12 gap-0 mx-auto mt-8">

                            <div class="col-span-12 font-bold caption-top">
                                {{ $selectedConversation->name }}
                            </div>

                            <div class="flex items-center justify-center h-full col-span-1 mx-auto">
                                <select wire:model="paginationStep" class="rounded">
                                    <option vlaue="10">10</option>
                                    <option vlaue="20">20</option>
                                    <option vlaue="30">30</option>
                                    <option vlaue="50">50</option>
                                    <option vlaue="100">100</option>
                                </select>
                            </div>

                            <div class="col-span-1 mx-auto">
                                <button wire:click="showDeleteAllMessageConfirmation" class="px-4 py-2 text-base font-medium text-white bg-indigo-500 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                                    {{ __('Delete Selected') }}
                                </button>
                            </div>

                            <div class="col-span-10"></div>

                            <!---Table Messages Heaqder--->
                            <div class="flex items-center justify-center col-span-1 p-2 font-bold text-left text-white bg-indigo-700 border border-black rounded-l">
                                <input type="checkbox" wire:model="allMessagesChecked" >
                            </div>
                            <div class="col-span-6 p-2 font-bold text-left text-white bg-indigo-700 border border-black">
                                {{ __('Message') }}
                            </div>
                            <div class="col-span-2 p-2 font-bold text-left text-white bg-indigo-700 border border-black">
                                {{ __('User') }}
                            </div>
                            <div class="col-span-2 p-2 font-bold text-left text-white bg-indigo-700 border border-black">
                                {{ __('Date') }}
                            </div>
                            <div class="col-span-1 p-2 font-bold text-left text-white bg-indigo-700 border border-black rounded-r">
                                {{ __('Actions') }}
                            </div>
                            <!---End Table Messages Heaqder--->

                            @if ($messages)
                                @foreach ($messages as $message)

                                <div class="flex items-center content-center justify-center col-span-1 p-2 text-left border-b border-l">
                                    <input type="checkbox" wire:model="selectedMessages" wire:key="messageCheckbos{{ $message->id }}" value="{{ $message->id }}">
                                </div>

                                <div class="col-span-6 p-2 text-left border-b border-l">
                                    {{ $message->body }}
                                </div>
                                <div class="col-span-2 p-2 text-left border-b border-l">
                                    {{ $message->sender->name }}
                                </div>
                                <div class="col-span-2 p-2 text-left border-b border-l">
                                    {{ $message->created_at }}
                                </div>
                                <div class="col-span-1 p-2 text-left border-b border-l">
                                    <i class="bi bi-gear-fill hover:text-red-900" wire:key="messageEdit-{{$message->id}}"></i>
                                    <i wire:click="showDeleteMessageConfirmation({{$message}})" class="bi bi-trash-fill hover:text-red-900" wire:key='messageDelete-{{$message->id}}'></i>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <!---Pagination Links--->
                        <div class="mt-8 btn-group">
                            <button wire:click="paginationGoToFirstPage" class="btn btn-outline-secondary">
                                <i class="bi bi-chevron-bar-left"></i>
                            </button>

                            @for ($i = $currentPage - ($paginationStep * 3), $count = 0; $count < 3; $i+=$paginationStep, $count++)
                                @if($i > 0)
                                <button wire:click="paginationGoToPage({{$i}})" wire:key="paginationPage-{{ $i }}" class="btn btn-outline-secondary">
                                    {{ $i }}
                                </button>
                                @endif
                            @endfor

                            @for ($i = $currentPage - 2, $count = 0; $count < 2; $i++, $count++)
                                @if($i > 0)
                                <button wire:click="paginationGoToPage({{$i}})" wire:key="paginationPage-{{ $i }}" class="btn btn-outline-secondary">
                                    {{ $i }}
                                </button>
                                @endif
                            @endfor
                            <button class="font-bold text-black btn btn-outline-secondary" wire:key="paginationPage-{{ $currentPage }}">
                                {{ $currentPage }}
                            </button>
                            @for ($i = $currentPage + 1, $count = 0; $i <= $lastPage && $count < 2; $i++, $count++)
                                <button wire:click="paginationGoToPage({{$i}})" wire:key="paginationPage-{{ $i }}" class="btn btn-outline-secondary">
                                    {{ $i }}
                                </button>
                            @endfor

                            @for ($i = $currentPage + $paginationStep, $count = 0; $i <= $lastPage && $count < 3; $i+=$paginationStep, $count++)
                                <button wire:click="paginationGoToPage({{$i}})" wire:key="paginationPage-{{ $i }}" class="btn btn-outline-secondary">
                                    {{ $i }}
                                </button>
                            @endfor

                            <button wire:click="paginationGoToLastPage" class="btn btn-outline-secondary">
                                <i class="bi bi-chevron-bar-right"></i>
                            </button>
                        </div>
                        <!---End Pagination Links--->
                        @endif
                        <!--if selectedConversation-->
                    </div>
                </div>
            </div>
        </div>
    </div>


@if ($deleteConfirmationVisible)
<!--modal content-->
<div class="fixed inset-0 w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative w-1/3 p-5 mx-auto bg-white border rounded-md shadow-lg top-20">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-500 rounded-full"		>
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">{{__('Warning')}}!</h3>
            <div class="py-3 mt-2 px-7">
                <p class="text-sm font-bold text-red-400">
                    {{__('Do you really want to delete the message form :sender with date :date?', ['sender' => $selectedMessage->sender->name, 'date' => $selectedMessage->created_at])}}
                </p>
            </div>
            <div class="py-3 mt-2 px-7">
                <p class="text-sm font-bold text-black-500">
                    {{ Str::limit($selectedMessage->body, 100, '...')}}
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button	class="w-5/12 px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                    {{__('Yes')}}
                </button>
                <button wire:click="hideDeleteMessageConfirmation" class="w-5/12 px-4 py-2 text-base font-medium text-white bg-indigo-500 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                    {{__('No')}}
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if ($deleteAllMessageConfirmationVisible)
<!--modal content-->
<div class="fixed inset-0 w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative w-1/3 p-5 mx-auto bg-white border rounded-md shadow-lg top-20">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-500 rounded-full"		>
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">{{__('Warning')}}!</h3>
            <div class="py-3 mt-2 px-7">
                <p class="text-sm font-bold text-red-400">
                    {{__('Do you really want to delete all selected messages?') }}
                </p>
            </div>

            <div class="items-center px-4 py-3">
                <button wire:click="deleteAllSelectedMessages"	class="w-5/12 px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                    {{__('Yes')}}
                </button>
                <button wire:click="hideDeleteAllMessageConfirmation" class="w-5/12 px-4 py-2 text-base font-medium text-white bg-indigo-500 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                    {{__('No')}}
                </button>
            </div>
        </div>
    </div>
</div>
@endif
</div>
