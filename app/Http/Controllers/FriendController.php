<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Services\FriendService;
use App\Http\Services\NotificationService;
use App\Http\Services\UserService;

class FriendController extends Controller
{
    public function __construct(public FriendService $friend_service)
    {

    }


    public function addFriend($friend_id,UserService $user_service,NotificationService $notification_service){

        try{

            $this->friend_service->addFriend($friend_id,$user_service,$notification_service);
            return $this->returnSuccessMessage('Friend request sent');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }


    public function acceptFriendRequest($user_id,UserService $user_service,$notification_id,NotificationService $notification_service){

        try{

            $this->friend_service->acceptRequest($user_id,$user_service,$notification_id,$notification_service);
            return $this->returnSuccessMessage('Friend request sent');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }

    }


    public function deleteReceivedFriendRequest($user_id,$notification_id,NotificationService $notification_service){

        try{

            $this->friend_service->deleteReceivedFriendRequest($user_id,$notification_id,$notification_service);
            return $this->returnSuccessMessage('Friend request deleted');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }


    public function cancelSentFriendRequest($friend_id){

        try{
            $this->friend_service->cancelSentFriendRequest($friend_id);
            return $this->returnSuccessMessage('Friend request canceled');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }
    }


    public function unfriend($friend_id){

        try{

            $this->friend_service->unfriend($friend_id);
            return $this->returnSuccessMessage('Unfriend is done');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }

    }



    public function getSuggestedFriends(){
        try{

            $friends = $this->friend_service->getSuggestedFriends();
            return $this->returnData('Data is returned successfully',$friends);
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }

    }


    public function getFriends($user_id){

        try{

            $friends = $this->friend_service->getFriendsResource($user_id);
            return $this->returnData('Data is returned successfully',[
                'friends_count'=>$friends->count(),
                'friends'=>$friends
            ]);

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }
    }



}
