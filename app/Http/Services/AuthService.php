<?php
namespace App\Http\Services;

use Exception;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthService{

    public function login($credentials){
        if(!$token = Auth::attempt($credentials)){
            throw new Exception('error in token please try again');
        }
        return $token;
    }

    public function logout(){
        return Auth::logout();
    }

    public function AuthUser(){
        return new UserResource(auth()->user());
    }









}
