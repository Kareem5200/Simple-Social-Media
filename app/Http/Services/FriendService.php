<?php
namespace App\Http\Services;

use App\Events\AcceptFriendEvent;
use App\Events\AddFriendEvent;
use App\Http\Repositories\FriendRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Exception;

class FriendService{

    public function __construct(public FriendRepository $friend_repository,public UserRepository $user_repository)
    {


    }

    public function addFriend(int $friend_id){

        if(auth()->id() == $friend_id || $this->friend_repository->checkFriendExists($friend_id)){

            throw new Exception('Error in friend ID');
        }

        $friend = $this->user_repository->getById($friend_id);
        event(new AddFriendEvent($friend,auth()->user()));
        return $this->friend_repository->addFriend($friend_id);
    }

    public function acceptRequest(int $user_id){

        if($this->friend_repository->checkReceivedRequestExists($user_id)){
            $user = $this->user_repository->getById($user_id);
            event(new AcceptFriendEvent($user , auth()->user()));

            return $this->friend_repository->acceptRequest($user_id);
        }

        throw new Exception('Error in user ID');
    }

    public function deleteReceivedFriendRequest(int $user_id){
        // if($this->friend_repository->checkReceivedRequestExists($user_id)){
        //     return $this->friend_repository->deleteReceivedFriendRequest($user_id);
        // }

        // throw new Exception('Error in user ID');

        if(!$this->friend_repository->deleteReceivedFriendRequest($user_id)){
            throw new Exception('Error in user ID');
        }


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



    public function getFriends(int $user_id){
        $friends = $this->friend_repository->getFriends($user_id);
        return UserResource::collection($friends);
    }

    public function getSuggestedFriends(){
        $suggested_friends = $this->friend_repository->getSuggestedFriends();
        return UserResource::collection($suggested_friends);

    }

}
