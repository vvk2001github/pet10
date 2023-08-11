<div class="w-1/2">

    <div wire:click='closeSuccesMessage' class="w-full mb-2" id="toastMsg">
        @if ($showSuccessMessage)
            <div class="px-4 py-3 text-teal-900 bg-teal-100 border-t-4 border-teal-500 rounded-b shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="w-6 h-6 mr-4 text-teal-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">{{ __('The message has been sent.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="w-full">
        <x-validation-errors />
    </div>
    <div class="w-full">
        <x-label for="title" value="{{ __('Title') }}" class="w-full"/>
        <x-input wire:model.defer="title" id="title" class="block w-full p-2 mt-1" name="title"  required autofocus />
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

