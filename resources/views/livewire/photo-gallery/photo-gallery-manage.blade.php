<div class="container">

    <div id="myDropzone" class="flex flex-wrap items-center justify-center w-full text-center border border-black border-dashed align-center" >
        <div id="dropHere">
            {{ __('Drop files here') }}
        </div>
    </div>

    <div>
        <x-dialog-modal wire:model="deletePhotoState">
            <x-slot name="title">
                &laquo;{{ $deletePhotoEntity ? $deletePhotoEntity->title : '' }}&raquo;
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the photo?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('deletePhotoState')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="destroyPhoto" wire:loading.attr="disabled">
                    {{ __('Delete Photo') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>

    <div id="sendImages" class="flex flex-col items-center invisible w-full">
        <x-button id="sendImagesButton" class="mt-2">
            {{ __('Send') }}
        </x-button>
    </div>

    <div class="flex flex-wrap mx-auto">
        @foreach ($photos as $photo)
        <div class="w-48 p-2 m-1 border-2 border-solid rounded border-indigo-950 bg-grey-light">
            <div class="flex justify-between py-1">
                <h3 class="text-sm font-bold" >{{ $photo->title }}</h3>
                <i wire:click='deletePhoto({{ $photo->id }})' class="bi bi-trash-fill hover:text-red-900"></i>
            </div>
            <div class="mt-2">
                <img class="m-1" src="{{ Storage::url('photogallery/thumb/'.$photo->image) }}" width="150px" height="150px"/>
            </div>
        </div>



        @endforeach
    </div>

    <script>
        let myDropzone = new Dropzone("div#myDropzone",
            {
                url: "/dropzone/store",
                autoProcessQueue: false,
                addRemoveLinks: true,
                acceptedFiles: "image/*",
                parallelUploads: 10,
                dictRemoveFile: "{{ __('Remove') }}",
                dictCancelUpload: "{{ __('Cancel upload') }}",
            });

        myDropzone.on("addedfile", file => {
            document.getElementById('dropHere').style.display = 'none';
            document.getElementById('sendImages').classList.remove('invisible');
        });

        myDropzone.on("reset", file => {
            document.getElementById('dropHere').style.display = 'block';
            document.getElementById('sendImages').classList.add('invisible');
            // this.Livewire.emit('refreshPhoto');
        });

        myDropzone.on("complete", file => {
            myDropzone.removeFile(file);
            this.Livewire.emit('refreshPhoto');
        });

        document.getElementById('sendImagesButton').addEventListener("click", () => {
            myDropzone.processQueue();
        }
        );

    </script>
</div>
