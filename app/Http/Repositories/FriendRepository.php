<?php
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Friendship;

class FriendRepository{

    public function getUser(): User
    {
        return auth()->user();
    }


    public function checkSentRequestExists($friend_id){
        return $this->getUser()->sentFriendRequests()->where('friend_id',$friend_id)->exists();
    }

    public function checkReceivedRequestExists($user_id){
        return $this->getUser()->receivedFriendRequests()->where('user_id',$user_id)->exists();
    }

    public function addFriend($friend_id){
        return $this->getUser()->sentFriendRequests()->create([
            'friend_id'=>$friend_id,
        ]);

    }
    public function acceptRequest($user_id){
        return $this->getUser()->receivedFriendRequests()->where('user_id',$user_id)->update([
            'status'=>'accepted',
        ]);
    }

    public function deleteReceivedFriendRequest($user_id){
        return $this->getUser()->receivedFriendRequests()->where('user_id',$user_id)->delete();
    }

}
