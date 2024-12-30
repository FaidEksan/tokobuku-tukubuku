<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageHandlerTrait
{
    public function uploadImage(UploadedFile $file, $directory = 'images'): string
    {
        $imageName = $file->hashName();
        $file->storeAs($directory, $imageName, 'public');
        return $imageName;
    }

    public function deleteImage($fileName, $directory = 'images'): void
    {
        if ($fileName && Storage::disk('public')->exists("{$directory}/{$fileName}")) {
            Storage::disk('public')->delete("{$directory}/{$fileName}");
        }
    }

    public function updateImage(?string $oldFileName, UploadedFile $newFile, $directory = 'images'): string
    {
        $this->deleteImage($oldFileName, $directory);
        return $this->uploadImage($newFile, $directory);
    }
}
