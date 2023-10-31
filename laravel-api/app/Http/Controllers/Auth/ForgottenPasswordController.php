<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgottenPasswordResetRequest;
use Illuminate\Support\Facades\Password;

class ForgottenPasswordController extends Controller
{
    /**
     * @param  ForgottenPasswordResetRequest  $request
     * @return void
     */
    public function sendResetLink(ForgottenPasswordResetRequest $request): void
    {
        Password::sendResetLink(
            $request->only('email')
        );
    }
}
