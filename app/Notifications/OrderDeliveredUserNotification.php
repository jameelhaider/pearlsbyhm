<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $trackingUrl = url('/track-my-order?tracking_id=' . $this->order->tracking_id);
        return (new MailMessage)
            ->subject('Your Order Has Been Delivered 🎉')
            ->greeting('Hello ' . $this->order->first_name . ' ' . $this->order->last_name . ',')
            ->line('We’re thrilled to let you know that your order **#' . $this->order->tracking_id . '** has been delivered successfully!')
            ->line('We hope you enjoy your purchase. If you have any issues or feedback, feel free to reach out.')
            ->line('')
            ->action('Check Order Status', $trackingUrl)
            ->line('')
            ->line('Thank you for trusting Pearls By HM 💎')
            ->salutation('Warm regards, Pearls By HM Team');
    }
}
