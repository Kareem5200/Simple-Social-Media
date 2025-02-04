<?php
namespace App\Http\Services;

use App\Http\Repositories\FriendRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Notifications\Friend\AcceptFriendNotification;
use App\Notifications\Friend\AddFriendNotification;
use Exception;

class FriendService{

    public function __construct(public FriendRepository $friend_repository,public UserRepository $user_repository)
    {


    }

    public function addFriend(int $friend_id,$notification_service){

        if(auth()->id() == $friend_id || $this->friend_repository->checkFriendExists($friend_id)){

            throw new Exception('Error in friend ID');
        }

        $friend = $this->user_repository->getById($friend_id);
        $this->friend_repository->addFriend($friend_id);
        $notification_service->sendNotificationToUser($friend ,new AddFriendNotification(auth()->user()));
    }

    public function acceptRequest(int $user_id,$notification_id,$notification_service){

        if($this->friend_repository->checkReceivedRequestExists($user_id)){
            $user = $this->user_repository->getById($user_id);


            if(!$this->friend_repository->acceptRequest($user_id)){
                throw new Exception('Error in update process');
            }

            $notification_service->sendNotificationToUser($user,new AcceptFriendNotification(auth()->user()));
           return  $notification_service->delete($notification_id);
        }

        throw new Exception('Error in user ID');
    }

    public function deleteReceivedFriendRequest(int $user_id ,$notification_id,$notification_service){

        if($this->friend_repository->deleteReceivedFriendRequest($user_id)){

            $notification_service->delete($notification_id);
        }
        throw new Exception('Error in user ID');


    }


    public function cancelSentFriendRequest(int $friend_id){
        // if($this->friend_repository->checkSentRequestExists($friend_id)){
        //     return $this->friend_repository->cancelSentFriendRequest($friend_id);
        // }
        // throw new Exception('Error in user ID');

        if(!$this->friend_repository->cancelSentFriendRequest($friend_id)){
            throw new Exception('Error in user ID');
        }

    }


    public function unfriend(int $friend_id){
        if(!$this->friend_repository->unfriend($friend_id)){

            throw new Exception('This user is not friend with you');

        }

    }



    public function getFriends(int $user_id,$columns = ['id','name','profile_image']){
        return $this->friend_repository->getFriends($user_id,$columns);
    }

    public function getFriendsResource(int $user_id,$columns = ['id','name','profile_image']){
        return UserResource::collection($this->getFriends($user_id,$columns));
    }

    public function getSuggestedFriends(){
        $suggested_friends = $this->friend_repository->getSuggestedFriends();
        return UserResource::collection($suggested_friends);

    }

}
