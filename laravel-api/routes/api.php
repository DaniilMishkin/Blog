<?php

use App\Http\Controllers\Auth\ForgottenPasswordController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])
        ->name('login');

    Route::middleware('auth:sanctum')
        ->post('logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::post('registration', [RegistrationController::class, 'store'])
        ->name('registration');

    Route::post('forgotten-password', [ForgottenPasswordController::class, 'sendResetLink'])
        ->name('password.reset');

    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/subscribe', [SubscribeController::class, 'toggleSubscribe'])
        ->name('user.subscribe.toggle');

    Route::get('user/{user}/subscriptions', [SubscribeController::class, 'getSubscriptions'])
        ->name('user.subscriptions');

    Route::get('user/{user}/subscribers', [SubscribeController::class, 'getSubscribers'])
        ->name('user.subscribers');

    Route::put('user/password', [UpdatePasswordController::class, 'update'])
        ->name('password.update');

    Route::resource('users', UserController::class);
    Route::get('me', [UserController::class, 'getAuthUser'])
        ->name('auth.user');

    Route::resource('posts', PostController::class);

    Route::post('likes', [LikeController::class, 'toggleLike']);
});
