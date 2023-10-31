<?php

namespace App\Services;

use App\Models\Like;

class LikeService
{
    public function toggleLike($userId, $postId): void
    {
        $currentLike = Like::where([
            'user_id' => $userId,
            'post_id' => $postId,
        ])->first();

        if ($currentLike) {
            $currentLike->delete();

            return;
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
    }
}
