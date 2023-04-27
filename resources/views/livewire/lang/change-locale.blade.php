<div class="relative">
    <div class="mt-4">
        @if (request()->routeIs('login'))
            <x-label for="pet10locale" value="{{ __('Locale') }}" />
        @endif
        <select name="pet10locale" id="pet10locale" wire:model="mylocale"
            @if (request()->routeIs('login')) class="block mt-1 w-full rounded"
            @else
                class="block w-full rounded -mt-4 border-none text-gray-500" @endif>
            <option value="en">English</option>
            <option value="ru">Русский</option>
        </select>
    </div>
</div>
