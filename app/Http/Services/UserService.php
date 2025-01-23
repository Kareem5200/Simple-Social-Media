<?php
namespace App\Http\Services;

use App\Models\User;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Resources\UserResource;

class UserService{

    public function __construct(public UserRepository $user_repository)
    {

    }


    //Create new user
    public function create(array $data){

        $data = checkUploadedFile($data,'profile_image','/public/profile_images');
        if(!$data){
            return false;
        }

        return  new UserResource($this->user_repository->create($data));
    }


    //Update user data
    public function update(array $data){

        if(array_key_exists('profile_image',$data)){

            $data = checkUploadedFile($data,'profile_image','/public/profile_images');
            if(!$data){
                return false;
            }
        }

        return $this->user_repository->update($data,auth()->user(),);
    }





}
