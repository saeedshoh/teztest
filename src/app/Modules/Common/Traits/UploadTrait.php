<?php namespace App\Modules\Common\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null, $size = null): string
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $publicPath = public_path() . $folder . '/'. $name. '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        if($size) {
            $img = Image::make($uploadedFile->getRealPath())->resize($size['width'], $size['height']);
            $img->save($publicPath, 100);
        }

        return $name. '.' . $uploadedFile->getClientOriginalExtension();
    }

    public function uploadProductImage(UploadedFile $uploadedFile): string
    {
        $name = Str::random(25);
        $folder = '/media/products/images';

        $uploadedFile->storeAs($folder . "/original", $name.'.'.$uploadedFile->getClientOriginalExtension(), 'public');

        $img = Image::make($uploadedFile->getRealPath())->resize(800, 800);
        $publicPath = public_path() . $folder . "/small/". $name. '.' . $uploadedFile->getClientOriginalExtension();
        $img->save($publicPath, 100);


        return $name. '.' . $uploadedFile->getClientOriginalExtension();
    }

}
