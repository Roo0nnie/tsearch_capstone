<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class CustomUserCodePassword extends Notification
{
    use Queueable;
    protected $password;
    protected $user_code;
    public $token;

    public function __construct($token, $user_code, $password)
    {
        $this->token = $token;
        $this->user_code = $user_code;
        $this->password =  $password;
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
        $password = $this->password;

        return (new MailMessage)
            ->subject('New Admin of Thesis Management System')
            ->line('You are receiving this email because you are now an Admin of this system.')
            // ->line('**Your User Code:** ' . '**' . $user_code . '**')
            ->line('**Your Temporary Password:** ' . '**' . $password . '**')
            ->line('Thank you!');
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
