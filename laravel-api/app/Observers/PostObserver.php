<?php

namespace App\Observers;

use App\Events\CreatePost;
use App\Events\DeletePost;
use App\Events\UpdatePost;
use App\Models\Post;
use App\Services\PostService;

class PostObserver
{
    public PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function created(Post $post)
    {
        broadcast(new CreatePost($post))
            ->toOthers();
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function updated(Post $post): void
    {
        broadcast(new UpdatePost($post))
            ->toOthers();
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function deleted(Post $post): void
    {
        broadcast(new DeletePost($post->id))
            ->toOthers();

        $this->postService->deleteImage($post);
    }
}
