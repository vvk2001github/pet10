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
                                                <i class="bi bi-gear-fill hover:text-red-900" wire:key='{{$conversation->id}}'></i>
                                                <i class="bi bi-trash-fill hover:text-red-900" wire:key='{{$conversation->id}}'></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if($selectedConversation)
                        <div>
                            {{ $selectedConversation->id }}
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
