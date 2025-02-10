<?php
namespace App\Http\Services;

use Exception;
use Carbon\Carbon;
use App\Http\Repositories\FriendRepository;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Repositories\NotificationRepository;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService{

    public function __construct(public NotificationRepository $notification_repository)
    {

    }

    public function sendNotificationToFriends($friends,object $notification_object){
         Notification::send($friends ,$notification_object);
    }

    public function sendNotificationToUser($user,object $notification_object){
        $user->notify($notification_object);
    }

    public function get(){
        $notifications = $this->notification_repository->get();
        if($notifications->isEmpty()){
            return false;
        }

        return [
            'notifications'=>NotificationResource::collection($notifications) ,
            'unread_notification_count'=>$this->notification_repository->unreadNotificationCount(),
        ];
    }

    public function delete($id){
        if(!$this->notification_repository->delete($id)){
            throw new Exception('Error in notification ID');
        }

    }

    public function first($id){

        if($notification = $this->notification_repository->first($id)){
            return $notification;
        }
        throw new Exception('Error in notification ID');
    }

    public function markAsRead($id){
        $notification = $this->notification_repository->first($id);
        if($notification){

            $this->notification_repository->markAsRead($notification);
        }
    }













}
