<?php

namespace App\Notifications\Like;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MakeLikeNotification extends Notification
{
    use Queueable;
    protected $content;
    public $tries = 3 ;


    /**
     * Create a new notification instance.
     */
    public function __construct(User $user , $likeable_type , $likeable_id)
    {
        $this->content=[
            'user'=>new UserResource($user),
            'likeable_url'=>url("api/get-$likeable_type",$likeable_id),
            'body'=>'Someone like your content',
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
