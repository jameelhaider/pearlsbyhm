<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ' . site_name() . ' 🎉')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We’re excited to have you join the ' . site_name() . ' family.')
            ->line('Here are your account details:')
            ->line('**Email:** ' . $this->email)
            ->line('**Password:** ' . $this->password)
            ->line('')
            ->line('✅ **Why shop with your account:**')
            ->line('- Your delivery addresses are saved for future shopping.')
            ->line('- Easily view and track all your past orders.')
            ->line('- Faster checkout experience — no need to fill details again!')
            ->line('')
            ->line('Simply log in anytime to enjoy a smoother shopping experience.')
            ->action('Login Now', url('/login'))
            ->line('Thank you for choosing ' . site_name() . '!');
    }
}
