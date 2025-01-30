<?php

namespace App\Notifications;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class addFriendNotification extends Notification
{
    use Queueable;


    private $notifiction_data ;


    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user )
    {

        $this->notifiction_data =[
            'accept_request_url'=>url('/api/accept-friend',$user->id),
            'delete_request_url'=> url('/api/delete-friendRequest',$user->id),
            'user'=>new UserResource($user),
            // 'profile_url'=>url('/api/profile',$user->id),
            // 'username'=>$this->user->name,
            // 'image'=>asset('/storage/profile_images/'.$this->user->profile_image),
            'body'=>'You have a friend request from new user',
        ] ;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->notifiction_data;
    }

    public function toBroadcast(object $notifiable): array
    {
        return $this->notifiction_data;
    }

    // public function broadcastOn()
    // {
    //     return new PrivateChannel('Friend.Requests.'.$this->notifiable_id);
    // }
}
