<?php

namespace App\Http\Controllers\Auth;

use App\Http\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;

class LoginController extends Controller
{

    public function __construct(public AuthService $auth_service)
    {

    }

    public function login(LoginRequest $request){

        try{
            $token = $this->auth_service->login($request->validated());
            return $this->returnToken('Authentication Successfully ',$token,$this->auth_service->AuthUser());

        }catch(Exception $exception){
            return $this->returnErrorMessage('Invalid Credentials');

        }
    }


    public function logout(){

        $this->auth_service->logout();
        return $this->returnSuccessMessage('Successfully logged out');
    }
}
