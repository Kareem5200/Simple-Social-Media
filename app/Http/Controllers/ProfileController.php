<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditBioRequest;
use App\Http\Requests\Profile\EditProfileImageRequest;
use App\Http\Services\UserService;
use App\Models\User;
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
    public function editBio(EditBioRequest $request){

        if($this->user_service->update($request->validated())){

            return $this->returnSuccessMessage('Your bio updated successfully');

        };
        return $this->returnErrorMessage('Something wrong');
    }

    //Edit the user profile image
    public function editProfileImage(EditProfileImageRequest $request){

        if($this->user_service->update($request->validated())){

            return $this->returnSuccessMessage('Your profile image updated successfully');
        };
        return $this->returnErrorMessage('Something wrong');

    }
}
