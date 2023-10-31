<?php

namespace App\Observers;

use App\Models\Like;

class LikeObserver
{
    /**
     * @param  Like  $like
     * @return void
     */
    public function created(Like $like): void
    {
        $like->post()->update([
            'likes_count' => ++$like->post->likes_count,
        ]);
    }

    /**
     * @param  Like  $like
     * @return void
     */
    public function deleted(Like $like): void
    {
        $like->post()->update([
            'likes_count' => --$like->post->likes_count,
        ]);
    }
}
