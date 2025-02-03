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
    protected $content ;
    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user , $sharedpost_ID)
    {
        $this->content = [
            'user'=>new UserResource($user),
            'post_url'=>url('api/get-share-post',$sharedpost_ID),
            'body'=>'Your post is shared',
        ];

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
        return $this->content;
    }

    public function toBroadcast(object $notifiable): array
    {
        return $this->content;
    }
}
