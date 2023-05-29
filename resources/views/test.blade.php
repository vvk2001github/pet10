<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Test')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="flex items-center justify-center gap-6 p-6 bg-gray-200 bg-opacity-25 lg:gap-8 lg:p-8" >

                    <img src="{{ Storage::url('img/roboface.jpg') }}" class="w-3/12 rounded-lg hover:w-3/4">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
