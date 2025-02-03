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


    private $notification_data;


    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        $this->notification_data = [
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
        return $this->notification_data;
    }

    public function toBroadcast(object $notifiable): array
    {
        return $this->notification_data;
    }
}
