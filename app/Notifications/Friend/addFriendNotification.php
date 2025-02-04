<?php

namespace App\Notifications\Friend;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddFriendNotification extends Notification
{
    use Queueable;


    public $tries = 3 ;


    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {


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
        return [
            'user'=>new UserResource($this->user),
            'accept_request_url'=>url('/api/accept-friend',[$this->user->id, $this->id]),
            'delete_request_url'=> url('/api/delete-friendRequest',[$this->user->id, $this->id]),
            'body'=>'You have a new friend request',
        ] ;
    }

    public function toBroadcast(object $notifiable): array
    {
        return [
            'user'=>new UserResource($this->user),
            'accept_request_url'=>url('/api/accept-friend',[$this->user->id, $this->id]),
            'delete_request_url'=> url('/api/delete-friendRequest',[$this->user->id, $this->id]),
            'body'=>'You have a new friend request',
        ] ;
    }
}
