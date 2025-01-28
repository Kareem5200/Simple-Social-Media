<?php

namespace App\Http\Controllers;

use App\Http\Services\FriendService;
use Exception;



class FriendController extends Controller
{
    public function __construct(public FriendService $friend_service)
    {

    }


    public function addFriend($friend_id){

        try{

            $this->friend_service->addFriend($friend_id);
            return $this->returnSuccessMessage('Friend request sent');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }


    public function acceptFriendRequest($user_id){

        try{

            $this->friend_service->acceptRequest($user_id);
            return $this->returnSuccessMessage('Friend request sent');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }

    }

    public function deleteReceivedFriendRequest($user_id){

        try{

            $this->friend_service->deleteReceivedFriendRequest($user_id);
            return $this->returnSuccessMessage('Friend request deleted');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }
}
