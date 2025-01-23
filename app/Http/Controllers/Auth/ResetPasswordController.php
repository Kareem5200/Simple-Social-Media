<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function sendResetLink(ResetPasswordRequest $request){
        $status = Password::sendResetLink($request->validated());
        return $status == Password::RESET_LINK_SENT ?
        $this->returnSuccessMessage($status):$this->returnErrorMessage($status);
    }

    public function resetPassword(){

    }
}
