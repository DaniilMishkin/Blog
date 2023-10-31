<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public const POSTS_IMAGES_DIRECTORY = 'posts_images';

    public const USERS_AVATARS_DIRECTORY = 'users_avatars';

    public function storeFile($directory, $file): bool|string
    {
        $fileName = $file->hashName();

        return Storage::putFileAs($directory, $file, $fileName);
    }

    public function deleteFile($fileUrl): void
    {
        if (Storage::exists($fileUrl)) {
            Storage::delete($fileUrl);
        }
    }

    public function updateFile($file, $directory, $oldFileUrl): bool|string
    {
        $this->deleteFile($oldFileUrl);

        return $this->storeFile($directory, $file);
    }
}
