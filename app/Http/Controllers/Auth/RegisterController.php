<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use Exception;

class RegisterController extends Controller
{
    public function __construct(public UserService $user_service,public AuthService $auth_service)
    {

    }

    public function register(RegisterRequest $request){

        try{
            $user = $this->user_service->create($request->validated());
            $token = $this->auth_service->login($request->only('email','password'));
            return $this->returnToken('User successfully Registered ',$token,$user);


        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());


        }
    }



}
