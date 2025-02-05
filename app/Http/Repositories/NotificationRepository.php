<?php

namespace App\Http\Repositories;

use App\Models\User;


class NotificationRepository{
    public function authUser():User{
        return auth()->user();
    }


    public function get(){
        return $this->authUser()->notifications()->select(['id','data','created_at','read_at'])->get();
    }
    public function unreadNotificationCount(){
        return $this->authUser()->unreadNotifications()->count();
    }



    public function delete( $id){
        return $this->authUser()->notifications()->where('id',$id)->delete();
    }
    public function first($id){
        return $notification = $this->authUser()->notifications()->where('id', $id)->first();

    }

    public function markAsRead($notification){
        return $notification->markAsRead();
    }

}
