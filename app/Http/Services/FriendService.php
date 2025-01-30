<?php
namespace App\Http\Services;

use App\Http\Repositories\FriendRepository;
use App\Http\Repositories\UserRepository;
use App\Notifications\AcceptFriendNotification;
use App\Notifications\addFriendNotification;
use Exception;

class FriendService{

    public function __construct(public FriendRepository $friend_repository,public UserRepository $user_repository)
    {


    }

    public function addFriend($friend_id){

        if(auth()->id() == $friend_id
            || $this->friend_repository->checkSentRequestExists($friend_id)
            || $this->friend_repository->checkReceivedRequestExists($friend_id)){
            throw new Exception('Error in friend ID');
        }


        $friend = $this->user_repository->getById($friend_id);
        $friend->notify(new addFriendNotification(auth()->user()));
        return $this->friend_repository->addFriend($friend_id);
    }

    public function acceptRequest($user_id){

        if($this->friend_repository->checkReceivedRequestExists($user_id)){
            $user = $this->user_repository->getById($user_id);
            $user->notify(new AcceptFriendNotification(auth()->user()));
            return $this->friend_repository->acceptRequest($user_id);
        }

        throw new Exception('Error in user ID');
    }

    public function deleteReceivedFriendRequest($user_id){
        if($this->friend_repository->checkReceivedRequestExists($user_id)){
            return $this->friend_repository->deleteReceivedFriendRequest($user_id);
        }

        throw new Exception('Error in user ID');

    }


    public function cancelSentFriendRequest($friend_id){
        if($this->friend_repository->checkSentRequestExists($friend_id)){
            return $this->friend_repository->cancelSentFriendRequest($friend_id);
        }
        throw new Exception('Error in user ID');

    }


    public function unfriend($friend_id){
        if(!$this->friend_repository->unfriend($friend_id)){
            
            throw new Exception('This user is not friend with you');

        }

    }

}
