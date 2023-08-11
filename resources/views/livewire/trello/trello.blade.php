<div>
<div class="container mx-auto">
    <!--<button wire:click='addGroup' class="block px-2 py-1 text-white bg-indigo-700 rounded appearance-none">{{__('Add')}}</button>-->
    <x-button wire:click='addGroup' type="button" class="appearance-none">
        {{ __('Add') }}
    </x-button>
    @if($addGroupState)
        <form wire:submit.prevent='saveGroup'>
            <!--<input wire:model.defer='title' type="text" id="title" class="block w-full px-4 py-3 mb-3 leading-tight border rounded appearance-none">-->
            <x-input wire:model.defer='title' class="w-full px-4 py-3 mb-3"></x-input>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
    @endif


</div>

<div>
    <x-dialog-modal wire:model="deleteGroupState">
        <x-slot name="title">
            &laquo;{{ $deleteGroupEntity ? $deleteGroupEntity->title : '' }}&raquo;
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the group?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deleteGroupState')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="destroyGroup" wire:loading.attr="disabled">
                {{ __('Delete Group') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>

<div class="container flex flex-wrap mx-auto" wire:sortable="updateOrder" wire:sortable-group="updateOrder">

    @foreach ($groups as $group)
        <div class="w-64 p-2 m-1 border-2 border-solid rounded border-indigo-950 bg-grey-light" wire:key="group-{{ $group->id }}" wire:sortable.item="{{ $group->id }}">
            <div class="flex justify-between py-1">
                <h3 class="text-sm font-bold" wire:sortable.handle>{{ $group->title }}</h3>
                <i wire:click='deleteGroup({{ $group->id }})' class="bi bi-trash-fill hover:text-red-900"></i>
            </div>
            <div wire:sortable-group.item-group="{{ $group->id }}" class="mt-2 text-sm">
                @foreach ($group->trello_cards as $card)
                <div class="flex justify-between p-2 mt-1 bg-white border-b rounded cursor-pointer border-grey hover:bg-grey-lighter" wire:key="card-{{ $card->id }}" wire:sortable-group.item="{{ $card->id }}" >
                    {{ $card->task }}
                    <i wire:click='deleteCard({{ $card->id }})' class="bi bi-x hover:text-red-900"></i>
                </div>
                @endforeach
            <p wire:click='addTask({{ $group->id }})' class="mt-3 cursor-pointer text-grey-dark">{{ __('Add task') }}...</p>

            @if($group_id == $group->id)
            <form wire:submit.prevent='saveTask'>
                <input wire:model.defer='task' type="text" id="task" class="block w-full px-4 py-3 mb-3 leading-tight border rounded appearance-none">
                @error('task')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </form>
            @endif

            </div>
        </div>
    @endforeach


</div>
</div>
