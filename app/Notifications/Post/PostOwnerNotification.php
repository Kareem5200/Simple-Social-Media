<?php

namespace App\Notifications\Post;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostOwnerNotification extends Notification
{
    use Queueable;

    public $tries = 3 ;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user ,public $sharedpost_ID)
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
            'post_url'=>url('api/get-share-post',[$this->sharedpost_ID,$this->id]),
            'body'=>'Your post is shared',
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        return [
            'user'=>new UserResource($this->user),
            'post_url'=>url('api/get-share-post',[$this->sharedpost_ID,$this->id]),
            'body'=>'Your post is shared',
        ];
    }
}
