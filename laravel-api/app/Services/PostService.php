<?php

namespace App\Services;

use App\Enums\AttachmentTypeEnum;

class PostService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function createImage($post, $image): void
    {
        $post->image()->create([
            'url' => $this->fileService->storeFile(FileService::POSTS_IMAGES_DIRECTORY, $image),
            'type' => AttachmentTypeEnum::POST_IMAGE,
        ]);
    }

    public function updateImage($post, $image): void
    {
        if (! is_string($image)) {
            $post->image()->update([
                'url' => $this->fileService->updateFile(
                    $image,
                    FileService::POSTS_IMAGES_DIRECTORY,
                    $post->image->url
                ),
            ]);
        }
    }

    public function deleteImage($post): void
    {
        $this->fileService->deleteFile($post->image->url);
        $post->image()->delete();
    }
}
