<?php

namespace App\Http\Services;

class TimelineService{

    public function timeline($friend_service,$user_service,$post_service,$sharePost_service){

        if($friends_ID = $friend_service->getFriends(auth()->id(),['id'],true)){
            return $user_service->getAllPosts($friends_ID,10,$post_service,$sharePost_service);
        }
        return null;

    }



}
