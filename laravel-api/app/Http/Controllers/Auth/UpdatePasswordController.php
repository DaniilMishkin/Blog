<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  UpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $this->userService->updatePassword(Auth::user(), $request->validated('new_password'));

        return response()->json([
            'message' => 'Password updated',
        ]);
    }
}
