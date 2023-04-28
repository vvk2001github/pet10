<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Configure Chat')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-8 p-6 lg:p-8 columns-1" >
                    <div class="container mx-auto">

                        @if($conversations)
                        <div class="mx-auto">
                            <table class="w-full border-b table-fixed border-x">
                                <caption class="caption-top">
                                    {{__('Conversation List')}}
                                </caption>
                                <thead>
                                    <tr>
                                    <th class="p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">{{__('Name')}}</th>
                                    <th class="p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">{{__('Message Count')}}</th>
                                    <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">{{__('Actions')}}</th>
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
                        <div class="mx-auto mt-8 grid grid-cols-12 gap-0">
                            <div class="col-span-12 caption-top font-bold">
                                {{ $selectedConversation->name }}
                            </div>
                            <div class="col-span-7 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">
                                {{ __('Message') }}
                            </div>
                            <div class="col-span-2 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">
                                {{ __('User') }}
                            </div>
                            <div class="col-span-2 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">
                                {{ __('Date') }}
                            </div>
                            <div class="col-span-1 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">
                                {{ __('Actions') }}
                            </div>

                            @if ($messages)
                                @foreach ($messages as $message)
                                <div class="col-span-7 p-2 text-left border-b border-l">
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
                        <div class="btn-group mt-8">
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
                            <button class="btn btn-outline-secondary font-bold text-black" wire:key="paginationPage-{{ $currentPage }}">
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
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
	<div class="mt-3 text-center">
		<div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-500"		>
			<i class="bi bi-exclamation-circle-fill"></i>
		</div>
		<h3 class="text-lg leading-6 font-medium text-gray-900">{{__('Warning')}}!</h3>
		<div class="mt-2 px-7 py-3">
			<p class="text-sm text-red-400 font-bold">
				{{__('Do you really want to delete the message form :sender with date :date?', ['sender' => $selectedMessage->sender->name, 'date' => $selectedMessage->created_at])}}
			</p>
		</div>
        <div class="mt-2 px-7 py-3">
			<p class="text-sm text-black-500 font-bold">
				{{ Str::limit($selectedMessage->body, 100, '...')}}
			</p>
		</div>
		<div class="items-center px-4 py-3">
			<button	class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-5/12 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-green-300">
				{{__('Yes')}}
			</button>
            <button wire:click="hideDeleteMessageConfirmation" class="px-4 py-2 bg-indigo-500 text-white text-base font-medium rounded-md w-5/12 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-green-300">
				{{__('No')}}
			</button>
		</div>
	</div>
</div>
</div>
@endif
</div>
