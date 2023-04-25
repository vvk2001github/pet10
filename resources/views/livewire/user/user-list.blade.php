<div class="mx-auto">
    @if ($showList)
    <table class="w-full border-b table-fixed border-x">
        <caption class="caption-top">
            User List
        </caption>
        <thead>
            <tr>
            <th class="p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">Name</th>
            <th class="p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">Email</th>
            <th class="p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">Roles</th>
            <th class="w-1/12 p-2 font-bold text-left text-white bg-indigo-700 border-b border-l border-indigo-700">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr class="odd:bg-gray-100 hover:!bg-stone-200">
                    <td class="p-2 text-left border-b border-l">{{ $user->name }}</td>
                    <td class="p-2 text-left border-b border-l">{{ $user->email }}</td>
                    <td class="p-2 text-left border-b border-l">
                        {{ $user->getRoleNames()->implode(', ') }}
                    </td>
                    <td class="p-2 text-left border-b border-l">
                        <i class="bi bi-gear-fill hover:text-red-900" wire:key='{{$user->id}}' wire:click="selectEditUser({{$user->id}})"></i>
                        <i class="bi bi-trash-fill hover:text-red-900" wire:key='{{$user->id}}' wire:click="selectDeleteUser({{$user->id}})"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form wire:submit.prevent='userAdd' action="" class="mx-auto">
        <div class="mx-auto">
            <div class="mx-auto justify-items-center">
                <input wire:model='username' type="text" id="username" class="w-2/6 mx-auto" placeholder="User name">
                <input wire:model='email' type="text" id="email" class="w-2/6 mx-auto" placeholder="User email">
                <button type="submit" class="px-4 py-2 font-bold text-white bg-indigo-700 rounded hover:bg-indigo-500">Add</button>
            </div>
        </div>
    </form>
    @endif
    @if ($showDeleteConfirmation)
        <i class="bi bi-arrow-left-circle-fill hover:text-red-900" wire:click="showList()"></i>
        <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
            <strong class="font-bold">Warning!</strong><br>
            <span class="block sm:inline">Do you really want to delete the user {{ $selectedUser?->name }}?</span>
        </div>
        <div class="grid grid-cols-2 gap-4 mx-auto">
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="deleteUser()">{{ __('Delete') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="showList()">{{ __('Cancel') }}</button>
            </div>
        </div>
    @endif
    @if ($showEdit)
        <i class="bi bi-arrow-left-circle-fill hover:text-red-900" wire:click="showList()"></i>
        <div class="px-4 py-3 text-blue-900 bg-blue-100 border-t-4 border-blue-500 rounded-b shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="w-6 h-6 mr-4 text-blue-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">{{ $selectedUser?->name }}</p>
                    <p class="text-sm">You are editing user {{ $selectedUser?->name }}.</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mx-auto">
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="saveUser()">{{ __('Save') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="showList()">{{ __('Cancel') }}</button>
            </div>
        </div>
    @endif
</div>
