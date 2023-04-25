<div class="mx-auto">
    @if ($showList)
    <table class="table-fixed border-x border-b w-full">
        <caption class="caption-top">
            User List
        </caption>
        <thead>
            <tr>
            <th class="font-bold p-2 border-b border-l border-indigo-700 text-left bg-indigo-700 text-white">Name</th>
            <th class="font-bold p-2 border-b border-l border-indigo-700 text-left bg-indigo-700 text-white">Roles</th>
            <th class="font-bold p-2 border-b border-l border-indigo-700 text-left bg-indigo-700 text-white w-1/12">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr class="odd:bg-gray-100 hover:!bg-stone-200">
                    <td class="p-2 border-b border-l text-left">{{ $user->name }}</td>
                    <td class="p-2 border-b border-l text-left">
                        {{ $user->getRoleNames()->implode(', ') }}
                    </td>
                    <td class="p-2 border-b border-l text-left">
                        <i class="bi bi-gear-fill hover:text-red-900"></i>
                        <i class="bi bi-trash-fill hover:text-red-900" wire:key='{{$user->id}}' wire:click="selectDeleteUser({{$user->id}})"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form wire:submit.prevent='userAdd' action="" class="mx-auto">
        <div class="mx-auto">
            <div class="mx-auto justify-items-center">
                <input wire:model='username' type="text" id="username" class="mx-auto w-2/6" placeholder="User name">
                <input wire:model='email' type="text" id="email" class="mx-auto w-2/6" placeholder="User email">
                <button type="submit" class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded">Add</button>
            </div>
        </div>
    </form>
    @endif
    @if ($showDeleteConfirmation)
        <i class="bi bi-arrow-left-circle-fill hover:text-red-900" wire:click="showList()"></i>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Warning!</strong>
            <span class="block sm:inline">Something seriously bad happened.</span>
          </div>
    @endif
</div>
