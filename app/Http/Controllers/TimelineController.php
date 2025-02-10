<?php

namespace App\Http\Controllers;

use App\Http\Services\FriendService;
use App\Http\Services\PostService;
use App\Http\Services\SharePostService;
use App\Http\Services\TimelineService;
use App\Http\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function __construct(public TimelineService $timeline_service)
    {

    }


    public function timeline(FriendService $friend_service,UserService $user_service,PostService $post_service,SharePostService $sharePost_service){
        try{
            if($posts = $this->timeline_service->timeline($friend_service,$user_service,$post_service,$sharePost_service)){
                return $this->returnData('All posts',$posts);
            }
            return $this->returnSuccessMessage('No posts');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }
    }
}
