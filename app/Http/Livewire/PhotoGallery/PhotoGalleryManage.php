<?php

namespace App\Http\Livewire\PhotoGallery;

use App\Models\PhotoGallery;
use Livewire\Component;

class PhotoGalleryManage extends Component
{
    public $deletePhotoState = false;

    public $deletePhotoEntity;

    public $editPhotoState = false;

    public $editPhotoEntity;

    public $photos;

    protected $listeners = ['refreshPhoto'];

    protected $rules = [
        'editPhotoEntity.title' => 'required|string|min:3',
    ];

    public function messages()
    {
        return [
            'editPhotoEntity.title.min' => __('The title field must be at least :num characters.', ['num' => '3']),
            'editPhotoEntity.title.required' => __('The :value field is required.', ['value' => 'Заголовок']),
        ];
    }

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
    }

    public function editPhoto(int $id)
    {
        $this->resetErrorBag();
        $this->editPhotoState = true;
        $this->editPhotoEntity = PhotoGallery::find($id);
    }

    public function render()
    {
        $this->refreshPhoto();

        return view('livewire.photo-gallery.photo-gallery-manage');
    }

    public function refreshPhoto()
    {
        $this->photos = auth()->user()->photos->sortByDesc('id');
    }

    public function updatePhoto()
    {
        $this->validate();
        $this->editPhotoEntity->save();
        $this->reset();
    }
}
