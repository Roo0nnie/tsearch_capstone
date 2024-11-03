<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuperAdminVerification extends Notification
{
    use Queueable;

    protected $verification_code;
    public $token;

    public function __construct($token, $verification_code)
    {
        $this->token = $token;
        $this->verification_code = $verification_code;
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
        return (new MailMessage)
            ->subject('Thesis Management System - Superadmin Verification')
            ->greeting('Hello, Superadmin')
            ->line('You are receiving this email because we received a login request as Super Administrator.')
            ->line('Your verification code is:')
            ->line('**' . $this->verification_code . '**')
            ->line('If you did not initiate this request, no further action is required.')
            ->salutation('Thank you, Thesis Management System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'verification_code' => $this->verification_code,
        ];
    }
}
