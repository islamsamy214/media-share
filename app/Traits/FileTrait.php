<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    public function uploadFile($file, $path)
    {
        $file_name = time() . '.' . $file->extension();
        $file->move(public_path($path), $file_name);

        return $file_name;
    } //end of uploading file

    public function deleteFile($file, $path)
    {
        Storage::disk('public_files')->delete($path . $file);
    } //end of deleting file

}
