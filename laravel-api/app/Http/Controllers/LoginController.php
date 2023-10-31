<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->session()
            ->regenerateToken();

        if (Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Logged successfully',
            ]);
        }

        return response()->json([
            'message' => 'Credentials is wrong',
        ], 401);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth('web')->logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return response()->json([
            'message' => 'User logged out',
        ]);
    }
}
