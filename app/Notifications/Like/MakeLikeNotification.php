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
    public $tries = 3 ;


    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user ,public $likeable_type ,public $likeable_id)
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
        return     [
            'user'=>new UserResource($this->user),
            'likeable_url'=>url("api/get-$this->likeable_type",[$this->likeable_id,$this->id]),
            'body'=>'Someone like your content',
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'user'=>new UserResource($this->user),
            'likeable_url'=>url("api/get-$this->likeable_type",[$this->likeable_id,$this->id]),
            'body'=>'Someone like your content',
        ];
    }
}
