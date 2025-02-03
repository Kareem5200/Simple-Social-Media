<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateSharePostRequest;
use App\Http\Services\FriendService;
use App\Http\Services\NotificationService;
use App\Http\Services\PostService;
use App\Http\Services\SharePostService;
use Exception;


class SharePostController extends Controller
{
    public function __construct(public SharePostService $sharePost_service)
    {

    }

    public function create(CreateSharePostRequest $request,FriendService $friend_service,
                            PostService $post_service,NotificationService $notification_service,$id){
        try{
            $this->sharePost_service->create($request->validated(),$friend_service,$post_service,$notification_service,$id);
            return $this->returnSuccessMessage('Post shared successfully');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());

        }

    }


    public function delete($id){

        try{

            $shared_post = $this->sharePost_service->get($id);
            $this->authorize('forceDelete',$shared_post);
            $this->sharePost_service->delete($shared_post);
            return $this->returnSuccessMessage('Post deleted successfully');
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());

        }
    }

    public function update(CreateSharePostRequest $request , $id){
        try{

            $shared_post = $this->sharePost_service->get($id);
            $this->authorize('update',$shared_post);
            $this->sharePost_service->update($shared_post,$request->validated());
            return $this->returnSuccessMessage('Post updated successfully');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());

        }

    }

    public function get($id){
        try{
            $shared_post = $this->sharePost_service->getWithPostResource($id);
            return $this->returnData('Success process', $shared_post);
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function getUserPosts($user_id){
        try{
            $shared_posts = $this->sharePost_service->getUserPostsResource($user_id);
            return $this->returnData('Success process', $shared_posts);
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }

    }

}
