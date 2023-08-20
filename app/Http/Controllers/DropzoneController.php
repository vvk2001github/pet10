<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoStoreRequest;
use App\Models\PhotoGallery;

class DropzoneController extends Controller
{
    public function store(PhotoStoreRequest $request)
    {
        $new_width = 150;
        $new_height = 150;

        $request->validated();
        $image = $request->file('file');
        $fileName = $image->hashName();
        $image->move(public_path('storage/photogallery'), $fileName);
        PhotoGallery::create([
            'user_id' => auth()->user()->id,
            'image' => $fileName,
        ]);

        $target_filename = public_path('storage/photogallery/thumb').'/'.$fileName;
        $fileName = public_path('storage/photogallery').'/'.$fileName;

        [$width, $height, $type, $attr] = getimagesize($fileName);
        $src = imagecreatefromstring(file_get_contents($fileName));
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($src);
        imagejpeg($dst, $target_filename);

        return response()->json(['success' => $fileName]);
    }
}
