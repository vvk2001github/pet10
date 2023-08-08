<div>
<div class="container mx-auto">
    <button wire:click='addGroup' class="block px-2 py-1 text-white bg-indigo-700 rounded appearance-none">{{__('Add')}}</button>
    @if($addGroupState)
        <form wire:submit.prevent='saveGroup'>
            <input wire:model.defer='title' type="text" id="title" class="block w-full px-4 py-3 mb-3 leading-tight border rounded appearance-none">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
    @endif


</div>
<div class="container flex flex-wrap mx-auto">

    @foreach ($groups as $group)
        <div class="w-64 p-2 m-1 border-2 border-solid rounded border-indigo-950 bg-grey-light">
            <div class="flex justify-between py-1">
                <h3 class="text-sm font-bold">{{ $group->title }}</h3>
                <i wire:click='deleteGroup({{ $group->id }})' class="bi bi-trash-fill hover:text-red-900"></i>
            </div>
            <div class="mt-2 text-sm">
                @foreach ($group->trello_cards as $card)
                <div class="p-2 mt-1 bg-white border-b rounded cursor-pointer border-grey hover:bg-grey-lighter">
                    {{ $card->task }}
                    <i class="bi bi-x hover:text-red-900"></i>
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
