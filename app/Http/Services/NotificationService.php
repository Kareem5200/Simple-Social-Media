<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Http\Repositories\FriendRepository;
use Illuminate\Support\Facades\Notification;
use App\Http\Repositories\NotificationRepository;

class NotificationService{

    public function __construct(public NotificationRepository $notification_repository,public FriendRepository $friend_repository)
    {

    }

    public function sendNotificationToFriends($friends,object $notification_object,$queueName = null, $connection = null, $delayInSeconds = null){
        // Apply dynamic queue name, connection, and delay if provided
        if ($queueName) {
            $notification_object->onQueue($queueName);
        }

        if ($connection) {
            $notification_object->onConnection($connection);
        }

        if ($delayInSeconds) {
            $notification_object->delay(Carbon::now()->addSeconds($delayInSeconds));
        }
        
         Notification::send($friends ,$notification_object);
    }

    public function sendNotificationToUser($user,object $notification_object){

        $user->notify($notification_object);

   }













}
