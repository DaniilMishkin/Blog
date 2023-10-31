<?php

namespace App\Services;

use App\Enums\AttachmentTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class UserService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function createUser($data, $password)
    {
        $user = User::create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($password),
        ]);

        $this->createAvatar($user);

        return $user;
    }

    public function updatePassword($user, $password): void
    {
        $user->update([
            'password' => Hash::make($password),
        ]);
    }

    public function updatePasswordByResetPasswordLink(array $credentials): void
    {
        Password::reset($credentials, function ($user, $password) {
            $user->update([
                'password' => Hash::make($password),
            ]);
        });
    }

    public function createAvatar($user): void
    {
        if (! Storage::exists(FileService::USERS_AVATARS_DIRECTORY)) {
            Storage::makeDirectory(FileService::USERS_AVATARS_DIRECTORY);
        }

        $avatarName = 'avatar-'.$user->id.'.png';

        Storage::exists(FileService::USERS_AVATARS_DIRECTORY);

        Avatar::create($user->full_name)
            ->save(storage_path('app/public/'.FileService::USERS_AVATARS_DIRECTORY.'/'.$avatarName));

        $user->avatar()->create([
            'url' => FileService::USERS_AVATARS_DIRECTORY.'/'.$avatarName,
            'type' => AttachmentTypeEnum::USER_AVATAR,
        ]);
    }

    public function updateAvatar($user, $image): void
    {
        if (! is_string($image)) {
            $user->avatar()->update([
                'url' => $this->fileService->updateFile(
                    $image,
                    FileService::USERS_AVATARS_DIRECTORY,
                    $user->avatar->url),
            ]);
        }
    }
}
