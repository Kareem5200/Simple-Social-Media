<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;

class RegisterController extends Controller
{
    public function __construct(public UserService $user_service,public AuthService $auth_service)
    {

    }

    public function register(RegisterRequest $request){

        if(!$user = $this->user_service->create($request->validated())){
            $this->returnErrorMessage('something wrong');
        };

        if ($token = $this->auth_service->login($request->only('email','password'))) {

            return $this->returnToken('User successfully Registered ',$token,$user);
        }

        return $this->returnErrorMessage('something wrong');
    }



}
