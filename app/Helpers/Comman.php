<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Image;

class Comman
{
    public static function file_upload($uploaded_file, $imagename_without_extension, $directory, $thumbs_sizes) {
        /*
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        
        $thumb_dir = $directory.config('constants.THUMB_DIR');
        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777, true);
        }*/

        $thumb_dir = $directory.config('constants.THUMB_DIR');

        $file = $uploaded_file->getClientOriginalName();
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $imagename_with_extension = $imagename_without_extension.'.'.$extension;

        foreach ($thumbs_sizes as $thumb_type => $thumb_size) {
            $thumb = Image::make($uploaded_file->getRealPath())->resize($thumb_size['width'], $thumb_size['height'])->encode($extension);
            $thumbname = $imagename_without_extension.'-'.$thumb_type.'.'.$extension;
            Storage::put($thumb_dir.$thumbname, $thumb);
        }
        // End thumb

        // upload image
        Storage::put($directory . $imagename_with_extension, file_get_contents($uploaded_file->getRealPath()));

        return $imagename_with_extension;
    }

    public static function file_remove($old_picture, $directory, $thumbs_sizes) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        
        $thumb_dir = $directory.config('constants.THUMB_DIR');
        if (!file_exists($thumb_dir)) {
            mkdir($thumb_dir, 0777, true);
        }

        $imagename_without_extension = pathinfo($old_picture, PATHINFO_FILENAME);
        $extension = pathinfo($old_picture, PATHINFO_EXTENSION);

        foreach ($thumbs_sizes as $thumb_type => $thumb_size) {
            $thumbname = $imagename_without_extension.'-'.$thumb_type.'.'.$extension;
            if (Storage::exists($thumb_dir.$thumbname)) {
                Storage::delete($thumb_dir.$thumbname);
            }
        }

        if (Storage::exists($directory.$old_picture)) {
            Storage::delete($directory.$old_picture);
        }
    }
}