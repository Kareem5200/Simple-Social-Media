<?php

namespace App\Notifications\Post;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;

class CreatePostNotification extends Notification implements ShouldQueue
{
    use Queueable , InteractsWithQueue;

    protected $content;
    public $tries = 3;

    /**
     * Create a new notification instance.
     */
    public function __construct( User $user, int $post_id)
    {
        $this->content = [
            'user'=> new UserResource($user),
            'post_url'=>url('api/get-post',$post_id),
            'body'=> "New post created",
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
        return  $this->content;
    }

    public function toBroadcast(object $notifiable): array
    {
        return  $this->content;
    }
}
