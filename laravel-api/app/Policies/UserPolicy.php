<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $updatableUser): bool
    {
        return $user->id === $updatableUser->id;
    }

    public function subscribe(User $user, $user_id): bool
    {
        return $user->id !== $user_id;
    }
}
