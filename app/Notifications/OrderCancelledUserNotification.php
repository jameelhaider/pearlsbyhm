<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelledUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
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
            ->subject('Your Order Has Been Cancelled ❌')
            ->greeting('Hello ' . $this->order->first_name . ' ' . $this->order->last_name . ',')
            ->line('We regret to inform you that your order **#' . $this->order->tracking_id . '** has been cancelled.')
            ->line('This may have occurred due to a stock issue, payment problem, or cancellation request.')
            ->line('If you believe this was a mistake or would like more details, please contact our support team.')
            ->line('We’re sorry for any inconvenience caused and appreciate your understanding.')
            ->salutation('Warm regards, Pearls By HM Team');
    }
}
