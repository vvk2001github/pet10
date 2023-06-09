<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Configure Users')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-8 p-6 lg:p-8 columns-1" >
                    <div class="container mx-auto">
                        @livewire('user.user-list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
