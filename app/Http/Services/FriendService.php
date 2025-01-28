<?php
namespace App\Http\Services;

use App\Http\Repositories\FriendRepository;
use App\Http\Repositories\UserRepository;
use Exception;

class FriendService{

    public function __construct(public FriendRepository $friend_repository,public UserRepository $user_repository)
    {


    }

    public function addFriend($friend_id){
        if(auth()->id() == $friend_id || $this->friend_repository->checkSentRequestExists($friend_id)){
            throw new Exception('Error in friend ID');
        }
        $friend = $this->user_repository->getById($friend_id);
        //then send notification
        return $this->friend_repository->addFriend($friend_id);
    }

    public function acceptRequest($user_id){

        if(!$this->friend_repository->checkReceivedRequestExists($user_id)){
            throw new Exception('Error in user ID');
        }

        $user = $this->user_repository->getById($user_id);
        //then send notification
        return $this->friend_repository->acceptRequest($user_id);
    }

    public function deleteReceivedFriendRequest($user_id){
        if(!$this->friend_repository->checkReceivedRequestExists($user_id)){
            throw new Exception('Error in user ID');
        }

        return $this->friend_repository->deleteReceivedFriendRequest($user_id);

    }

}
