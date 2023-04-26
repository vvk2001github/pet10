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
    <form wire:submit.prevent='userAdd' action="" class="w-full">
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="username">
                    Name
                </label>
                <input wire:model='username' type="text" id="username" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="User name">
                @error('username') <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror
            </div>
            <div class="w-full md:w-5/12 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                    Email
                </label>
                <input wire:model='email' type="text" id="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="User email">
                @error('email') <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror
            </div>
            <div class="w-full md:w-2/12 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">&nbsp;</label>
                <button type="submit" class="appearance-none block w-full bg-indigo-700 text-white rounded py-3 px-4">Add</button>
            </div>
        </div>
    </form>
    @endif
    @if ($showDeleteConfirmation)
        <i class="bi bi-arrow-left-circle-fill hover:text-red-900" wire:click="showUserList()"></i>
        <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
            <strong class="font-bold">Warning!</strong><br>
            <span class="block sm:inline">Do you really want to delete the user {{ $selectedUser?->name }}?</span>
        </div>
        <div class="grid grid-cols-2 gap-4 mx-auto">
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="deleteUser()">{{ __('Delete') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="showUserList()">{{ __('Cancel') }}</button>
            </div>
        </div>
    @endif
    @if ($showEdit)
        <i class="bi bi-arrow-left-circle-fill hover:text-red-900" wire:click="showUserList()"></i>
        <div class="px-4 py-3 text-blue-900 bg-blue-100 border-t-4 border-blue-500 rounded-b shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="w-6 h-6 mr-4 text-blue-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">{{ $selectedUser?->name }}</p>
                    <p class="text-sm">You are editing user {{ $selectedUser?->name }}.</p>
                </div>
            </div>
        </div>

        <br />
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required>
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
            <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="mb-6">
            <label for="confpassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
            <input type="password" id="confpassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label for="allroles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Roles</label>
                <select wire:model="selectedRoles" id="allroles" class="form-multiselect block w-full mt-1" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{$role->name}}</option>
                    @endforeach


                </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mx-auto">
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="saveUser()">{{ __('Save') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" wire:click="showUserList()">{{ __('Cancel') }}</button>
            </div>
        </div>

    @endif
</div>
