<?php
namespace App\Http\Services;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Models\SharedPost;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Resources\PostResource;



class UserService{

    public function __construct(public UserRepository $user_repository)
    {

    }

    public function getUser($user_id,$columns =['users.*']){
        return $this->user_repository->getById($user_id ,$columns);
    }



    //Create new user
    public function create(array $data){

        $data = checkUploadedFile($data,'profile_image','/public/profile_images');
        if(!$data){
            throw new Exception('error in uploading image');
        }

        return  new UserResource($this->user_repository->create($data));
    }

    //Update user data
    public function updateprofile(array $data){

        return $this->user_repository->update($data);
    }

    public function updateImage(array $data){

            $data = checkUploadedFile($data,'profile_image','/public/profile_images');
            if(!$data){
                throw new Exception('Error in uploading file');
            }
            return $this->user_repository->update($data);


    }

    public function updatePassword(array $data){

        if(!Hash::check($data['old_password'],auth()->user()->password)) {
                throw new Exception('wrong old password');
        }

        unset($data['old_password']);
        return $this->user_repository->update($data);



    }



    public function getAllPosts(array $users_id,$pagination_number,$post_service, $sharedPost_service){

        $last_page = 0;
        $merged_posts = [];



        if($posts = $post_service->getUserPosts($users_id,$pagination_number)){
            $merged_posts = array_merge($merged_posts, $post_service->mapPaginatedPosts($posts)->items());
            $last_page = $posts->lastPage();
        }

        if($shared_posts = $sharedPost_service->getSharedPosts($users_id,$pagination_number)){
            $merged_posts = array_merge($merged_posts, $sharedPost_service->mapPaginatedSharedPosts($shared_posts)->items());
            $shared_posts->lastPage() < $last_page ?: $last_page =  $shared_posts->lastPage();

        }




        return [
        'posts' =>$merged_posts,
        'current_page' =>request()->get('page', 1),
        'last_page' =>$last_page,
        'per_page' => count($merged_posts),
        ];

    }





}
