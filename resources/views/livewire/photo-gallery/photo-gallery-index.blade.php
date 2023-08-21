<div class="container">
    <div class="w-full text-right">
        <a class="text-gray-600 hover:underline" href="{{ route('photogallery.manage') }}">{{ __('Go to my photos') }}</a>
    </div>
    <div>
        @if(isset($showPhotoEntity))
            <x-dialog-modal wire:model="showPhotoState">
                <x-slot name="title">
                    <div class="w-full text-left">
                        {{ $showPhotoEntity->title}}
                    </div>
                </x-slot>

                <x-slot name="content">
                    <img class="m-1" src="{{ Storage::url('photogallery/'.$showPhotoEntity->image) }}"/>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('showPhotoState')" wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-secondary-button>
                </x-slot>
            </x-dialog-modal>
        @endif
    </div>

    <div class="flex flex-wrap mx-auto">
        @foreach ($photos as $photo)
        <div class="w-1/3 p-2 m-1 border-2 border-gray-500 border-solid rounded bg-grey-light">
            <div class="flex justify-between py-1">
                <h3 class="text-sm font-bold" >{{ $photo->title }}</h3>
            </div>
            <div wire:click='showPhoto({{ $photo->id }})' class="mt-2 cursor-pointer">
                <img class="w-full m-1" src="{{ Storage::url('photogallery/'.$photo->image) }}" />
            </div>
        </div>
        @endforeach
    </div>
    {{ $photos->links() }}
</div>
