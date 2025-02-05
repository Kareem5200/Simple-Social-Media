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

    public $tries = 3 ;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user,public $commentable_type,public $commentable_id,public $comment_ID)
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
        return   [
            'user'=>new UserResource($this->user),
            'comment_url'=>url('api/get-comment',[$this->comment_ID,$this->id]),
            'commentable_url'=>url("api/get-$this->commentable_type",[$this->commentable_id,$this->id]),
            'body'=>'Have a new comment on your post',
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        return   [
            'user'=>new UserResource($this->user),
            'comment_url'=>url('api/get-comment',[$this->comment_ID,$this->id]),
            'commentable_url'=>url("api/get-$this->commentable_type",[$this->commentable_id,$this->id]),
            'body'=>'Have a new comment on your post',
        ];
    }
}
