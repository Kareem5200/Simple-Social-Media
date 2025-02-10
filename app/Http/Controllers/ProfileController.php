<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileImageRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\PostService;
use App\Http\Services\SharePostService;
use App\Http\Services\UserService;
use Exception;

class ProfileController extends Controller
{

    public function __construct(public UserService $user_service)
    {

    }

    //get user profile => included the user data and its posts
    public function profile(PostService $post_service ,SharePostService $sharedPost_service ,$user_id)
    {
        try{
            $profile_owner = new UserResource($this->user_service->getUser($user_id, ['id','name','profile_image','bio']));
            $profile_content= $this->user_service->getAllPosts([$user_id],10,$post_service,$sharedPost_service);



            return $this->returnData('profile data',[
                'profile_owner'=>$profile_owner ,
                'profile_content'=>$profile_content,
            ]);

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }

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
