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
        @error('bigwarning')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{__('Warning')}}!</strong>
            <span class="block sm:inline">{{$message}}</span>
          </div>
        @enderror

        <br />



        <!----->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="editusername">
                    Name
                </label>
                <input wire:model='editusername' type="text" id="editusername" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="User name">
                @error('editusername') <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror
            </div>
            <div class="w-full md:w-5/12 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="editemail">
                    Email
                </label>
                <input wire:model='editemail' type="text" id="editemail" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="User email">
                @error('editemail') <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror
            </div>
        </div>
        <!--Passwords-->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="editpassword">
                Password
              </label>
              <input wire:model="editpassword" name="editpassword" id="editpassword" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="password" placeholder="******************">
              @error('editpassword') <p class="text-red-500 text-xs italic">{{$message}}</p> @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="editpassword_confirmation">
                Confirm password
              </label>
              <input wire:model="editpassword_confirmation" name="editpassword_confirmation" id="editpassword_confirmation" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="password" placeholder="******************">
            </div>
        </div>
        <!--Passwords-->
        <!----->

        <div class="mb-6">
            <label for="allroles" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Roles</label>
                <select wire:model="selectedRoles" id="allroles" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{$role->name}}</option>
                    @endforeach


                </select>
        </div>

        <div class="grid grid-cols-3 gap-4 mx-auto">
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700" wire:click="removeAllRoles()">{{ __('Remove All Roles') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700" wire:click="userSave()">{{ __('Save') }}</button>
            </div>
            <div class="text-center">
                <button class="px-4 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700" wire:click="showUserList()">{{ __('Cancel') }}</button>
            </div>
        </div>

    @endif
</div>
