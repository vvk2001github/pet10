<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 flex items-center justify-center gap-6 lg:gap-8 p-6 lg:p-8" >

                    <img src="{{ Storage::url('img/roboface.jpg') }}" class="rounded-lg w-3/12 hover:w-3/4">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
