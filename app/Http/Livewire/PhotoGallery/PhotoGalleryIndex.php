<?php

namespace App\Http\Livewire\PhotoGallery;

use App\Models\PhotoGallery;
use Livewire\Component;
use Livewire\WithPagination;

class PhotoGalleryIndex extends Component
{
    use WithPagination;

    public $showPhotoState = false;

    public $showPhotoEntity;

    public function render()
    {
        return view('livewire.photo-gallery.photo-gallery-index', [
            'photos' => PhotoGallery::orderBy('id', 'DESC')->paginate(4),
        ]);
    }

    public function showPhoto(int $id): void
    {
        $this->showPhotoEntity = PhotoGallery::find($id);
        $this->showPhotoState = true;
    }
}
