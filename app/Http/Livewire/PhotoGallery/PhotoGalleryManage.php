<?php

namespace App\Http\Livewire\PhotoGallery;

use App\Models\PhotoGallery;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PhotoGalleryManage extends Component
{
    public $deletePhotoState = false;

    public $deletePhotoEntity;

    public $photos;

    protected $listeners = ['refreshPhoto'];

    public function deletePhoto(int $id): void
    {
        $this->deletePhotoEntity = PhotoGallery::find($id);
        $this->deletePhotoState = true;
    }

    public function destroyPhoto()
    {
        $filename = $this->deletePhotoEntity->image;

        unlink(public_path('storage/photogallery/thumb').'/'.$filename);
        unlink(public_path('storage/photogallery').'/'.$filename);

        $this->deletePhotoEntity->delete();
        $this->deletePhotoEntity = null;
        $this->reset();
        $this->refreshPhoto();
    }

    public function render()
    {
        $this->refreshPhoto();
        return view('livewire.photo-gallery.photo-gallery-manage');
    }

    public function refreshPhoto()
    {
        $this->photos = auth()->user()->photos->sortBy('created_at');
    }

}
