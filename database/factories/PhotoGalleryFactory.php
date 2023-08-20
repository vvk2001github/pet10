<?php

namespace Database\Factories;

use App\Models\PhotoGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhotoGallery>
 */
class PhotoGalleryFactory extends Factory
{
    protected $model = PhotoGallery::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $new_width = 150;
        $new_height = 150;

        $path = public_path('storage/photogallery');
        $thumb_path =public_path('storage/photogallery/thumb');


        $fakerFileName = $this->faker->image(
            $path,
            800,
            600
        );
        // echo $path.PHP_EOL;
        // echo $thumb_path.PHP_EOL;
        // echo $fakerFileName.PHP_EOL;

        $target_filename = $thumb_path.'/'.basename($fakerFileName);
        $fileName = $path.'/'.basename($fakerFileName);

        list($width, $height, $type, $attr) = getimagesize( $fileName );
        $src = imagecreatefromstring( file_get_contents( $fileName ) );
        $dst = imagecreatetruecolor( $new_width, $new_height );
        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
        imagedestroy( $src );
        imagejpeg( $dst, $target_filename );


        return [
            'user_id' => 1,
            'title' => $this->faker->text(20),
            'image' => basename($fakerFileName),
        ];
    }
}
