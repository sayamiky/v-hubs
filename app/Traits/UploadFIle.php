<?php

namespace App\Traits;

trait UploadFile
{
    public function upload($file, $folder)
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs($folder, $originalName, 'public');
        return $path;
    }
}
