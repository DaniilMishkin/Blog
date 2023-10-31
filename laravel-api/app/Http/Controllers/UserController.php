<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $users = User::sort($request->all())
            ->filter($request->all())
            ->paginate(10);

        return UserResource::collection($users)->all();
    }

    /**
     * @param  User  $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @param  UserUpdateRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $this->userService->updateAvatar($user, $request->validated('avatar'));

        $user->update($request->validated());

        $user->load('avatar');

        return new UserResource($user);
    }

    /**
     * @return UserResource
     */
    public function getAuthUser(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
