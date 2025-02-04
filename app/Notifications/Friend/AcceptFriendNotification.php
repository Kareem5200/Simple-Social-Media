<?php

namespace App\Notifications\Friend;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Http\Resources\UserResource;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AcceptFriendNotification extends Notification
{
    use Queueable;
    protected $content;
    public $tries = 3 ;



    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->content = [
            'user'=>new UserResource($user),
            'body'=>'Your friend request accepted',
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
