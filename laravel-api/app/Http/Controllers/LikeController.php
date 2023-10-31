<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeToggleRequest;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * @param  LikeToggleRequest  $request
     * @return JsonResponse
     */
    public function toggleLike(LikeToggleRequest $request): JsonResponse
    {
        $this->likeService->toggleLike(Auth::id(), $request->validated('post_id'));

        return response()->json([
            'message' => 'Toggle like successful',
        ]);
    }
}
