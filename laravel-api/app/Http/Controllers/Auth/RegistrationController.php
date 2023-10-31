<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\User\PasswordMail;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  RegisterUserRequest  $request
     * @return JsonResponse
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        $password = Str::random(10);

        $user = $this->userService->createUser($request->validated(), $password);

        Mail::to($request->validated('email'))
            ->send(new PasswordMail($user->first_name, $password));

        return response()->json([
            'message' => 'Registered successfully',
        ]);
    }
}
