<?php

namespace App\Notifications\comment;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MakeCommentNotification extends Notification
{
    use Queueable;
    protected $content;
    public $tries = 3 ;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user,$commentable_type,$commentable_id,$comment_ID)
    {
        $this->content = [
            'user'=>new UserResource($user),
            'comment_url'=>url('api/get-comment',$comment_ID),
            'commentable_url'=>url("api/get-$commentable_type",$commentable_id),
            'body'=>'Have a new comment on your post',
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
