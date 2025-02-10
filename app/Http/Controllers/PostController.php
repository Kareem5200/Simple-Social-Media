<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Services\PostService;
use App\Http\Requests\Post\CreateTextPostRequest;
use App\Http\Requests\Post\CreateImagePostRequest;
use App\Http\Requests\Post\ConvertMediaToTextPostRequest;
use App\Http\Requests\Post\ConvertTextToImagePostRequest;
use App\Http\Requests\Post\UpdateImagePostRequest;
use App\Http\Requests\Post\UpdateTextPostRequest;
use App\Http\Services\FriendService;
use App\Http\Services\NotificationService;
use Exception;

class PostController extends Controller
{
    private $create_success_message = 'Post created successfully';
    private $update_success_message = 'Post updated successfully';

    public function __construct(public PostService $post_service)
    {

    }


    public function checkPostAuthorization(string $authorization ,int $id,bool $trashed = false):Post{
        if($trashed){
            $post = $this->post_service->getPostWithoutData($id,$trashed);
        }else{

            $post = $this->post_service->getPostWithoutData($id);
        }
        $this->authorize($authorization,$post);
        return $post;
    }


    //Create new text post
    public function createTextPost(CreateTextPostRequest $request,NotificationService $notification_service,FriendService $friend_service){

        try{
            $this->post_service->createTextPost($friend_service,$notification_service,$request->validated());
            return $this->returnSuccessMessage($this->create_success_message);
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    //create new image post
    public function createImagePost(CreateImagePostRequest $request,NotificationService $notification_service,FriendService $friend_service){
        try{

            $this->post_service->createImagePost($friend_service,$notification_service,$request->validated());
            return $this->returnSuccessMessage($this->create_success_message);

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }




    public function getPost(NotificationService $notification_service,$id ,$notification_id=null){

        try{

            return $this->returnData('Post returned successfully',$this->post_service->getPost($id ,$notification_id ,$notification_service));

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }
    }


    //Delete for post of the auth user
    public function forceDeletePost($id){


        try{
            $post = $this->checkPostAuthorization('forceDelete',$id);
            $this->post_service->deletePost($post);
            return $this->returnSuccessMessage('Your post deleted succesfully');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }


    }


    public function updateTextPost(UpdateTextPostRequest $request ,$id){


        try{
            $post = $this->checkPostAuthorization('update',$id);
            $this->post_service->updateTextPost($post,$request->validated());
            return $this->returnSuccessMessage($this->update_success_message);
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }


    public function convertTextToImagePost(ConvertTextToImagePostRequest $request,$id){


        try{
            $post = $this->checkPostAuthorization('update',$id);
            $this->post_service->convertTextToImagePost($post,$request->validated());
            return $this->returnSuccessMessage($this->update_success_message);

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }


    public function updateImagePost(UpdateImagePostRequest $request ,$id){


        try{
            $post = $this->checkPostAuthorization('update',$id);
            $this->post_service->updateImagePost($post,$request->validated());
            return $this->returnSuccessMessage($this->update_success_message);
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function convertMediaToTextPost(ConvertMediaToTextPostRequest $request,$id){

        try
        {
            $post = $this->checkPostAuthorization('update',$id);
            $this->post_service->convertMediaToTextPost($post,$request->validated());
            return $this->returnSuccessMessage($this->update_success_message);

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function makeOnlyMePost($id){


        try{
            $post = $this->checkPostAuthorization('delete',$id);
            $this->post_service->makeOnlyMePost($post);
            return $this->returnSuccessMessage('Post is for you only');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function removeOnlyMeOnPost($id){

        try{

            $post = $this->checkPostAuthorization('restore',$id,true);
            if($this->post_service->RemoveOnlyMeOnPost($post)){

                return $this->returnSuccessMessage('Post restored successfully');
            }

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }





}
