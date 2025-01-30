<?php
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Friendship;

class FriendRepository{

    public function getUser(): User
    {
        return auth()->user();
    }


    //Check if i send this request before
    public function checkSentRequestExists($friend_id){
        return $this->getUser()->sentFriendRequests()->where('friend_id',$friend_id)->exists();
    }



    //check if the user send request to me
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



    public function cancelSentFriendRequest($friend_id){
        return $this->getUser()->sentFriendRequests()->where('friend_id',$friend_id)->delete();
    }

    public function unfriend($friend_id){
        return Friendship::where(['user_id'=>auth()->id(),'friend_id'=>$friend_id,'status'=>'accepted'])
                ->orWhere(['user_id'=>$friend_id,'friend_id'=>auth()->id(),'status'=>'accepted'])
                ->delete();
    }

}
