<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToggleSubscribeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    /**
     * @param  ToggleSubscribeRequest  $request
     * @return JsonResponse
     */
    public function toggleSubscribe(ToggleSubscribeRequest $request): JsonResponse
    {
        Auth::user()->subscriptions()
            ->toggle($request->validated('user_id'));

        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function getSubscriptions(User $user)
    {
        $subs = $user->subscriptions()
            ->paginate(10);

        return UserResource::collection($subs)->all();
    }

    public function getSubscribers(User $user)
    {
        $subs = $user->subscribers()
            ->paginate(10);

        return UserResource::collection($subs)->all();
    }
}
