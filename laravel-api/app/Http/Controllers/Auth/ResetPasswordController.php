<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  ResetPasswordRequest  $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $this->userService->updatePasswordByResetPasswordLink($request->validated());

        return response()->json([
            'message' => 'Password reset successfully',
        ]);
    }
}
