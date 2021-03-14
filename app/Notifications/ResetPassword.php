<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $token;

        public function __construct($token)
        {
            $this->token = $token;
        }

        public function via($notifiable)
        {
            return ['mail'];
        }

        public function toMail($notifiable)
        {
            return (new MailMessage)
                ->subject('Reset Password')
                ->line('You are receiving this email because we received a password reset request for your account.')
                ->action('Reset Password', url('reset-password', $this->token))
                ->line('If you did not request a password reset, no further action is required.');
        }
}
