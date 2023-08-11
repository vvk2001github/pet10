<div class="w-1/2">
    <div class="w-full">
        <x-validation-errors />
    </div>
    <div class="w-full">
        <x-label for="title" value="{{ __('Title') }}" class="w-full"/>
        <x-input wire:model.defer="title" id="title" class="block w-full pl-1 mt-1" name="title"  required autofocus />
    </div>

    <div class="w-full">
        <x-label for="message" value="{{ __('Message') }}" class="w-full mt-2"/>
        <textarea wire:model.defer="message" rows="5" cols="60" id="message" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-gray-800 focus:ring-gray-800" name="message"  required></textarea>
    </div>

    <div class="flex flex-col items-center w-full">
        <x-button wire:click='send' class="mt-2">
            {{ __('Send') }}
        </x-button>
    </div>
</div>
