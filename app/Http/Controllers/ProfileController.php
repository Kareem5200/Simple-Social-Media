<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileImageRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class ProfileController extends Controller
{

    public function __construct(public UserService $user_service)
    {

    }

    //get user profile => included the user data and its posts
    public function profile(User $user){

    }



    //Edit the user bio
    public function updateProfile(UpdateProfileRequest $request){

        try{
            $this->user_service->updateprofile($request->validated());
            return $this->returnSuccessMessage('Your profile updated successfully');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }

    //Edit the user profile image
    public function updateProfileImage(UpdateProfileImageRequest $request){

        try{
            $this->user_service->updateImage($request->validated());
            return $this->returnSuccessMessage('Your profile image updated successfully');
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function updatePassword(UpdatePasswordRequest $request){

        try{
            $this->user_service->updatePassword($request->validated());
            return $this->returnSuccessMessage('Your password updated successfully');
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }
    }
}
