<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class CustomUserCode extends Notification
{
    use Queueable;
    protected $user_code;
    public $token;

    public function __construct($token, $user_code)
    {
        $this->token = $token;
        $this->user_code = $user_code;
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
    public function toMail($notifiable)
    {
        $user_code = $this->user_code;

        return (new MailMessage)
            ->subject('New User of Thesis Management System')
            ->line('You are receiving this email because we received that you are a new user of this system.')
            ->line('**Your User Code:** ' . '**' . $user_code . '**')
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
