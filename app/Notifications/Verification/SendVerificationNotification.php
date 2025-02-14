<?php

namespace App\Notifications\Verification;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class SendVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $tries = 3;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */

     public function toMail(object $notifiable): MailMessage
     {



         return (new MailMessage)
                     ->subject('Social Media Project')
                     ->greeting("Dear {$notifiable->name},")
                     ->line('Please verify your account.')
                     ->action('Verify',URL::temporarySignedRoute(
                                     'verify',
                                     Carbon::now()->addDay(),
                                     [
                                         'id' => $notifiable->getKey(),
                                         'hash' => sha1($notifiable->getEmailForVerification())
                                     ]
                                 ))
                     ->line('This link will expire in day from ' . now()->format('h:i A'))
                     ->line('Thank you for using our application!');
     }


}
