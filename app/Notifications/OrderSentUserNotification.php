<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderSentUserNotification extends Notification implements ShouldQueue
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
            ->subject('Your Order Has Been Sent to the Delivery Company 🚚')
            ->greeting('Hello ' . $this->order->first_name . ' ' . $this->order->last_name . ',')
            ->line('Your order **#' . $this->order->tracking_id . '** has been handed over to our delivery partner.')
            ->line('It’s on its way to you — you’ll be notified once it’s delivered.')
            ->line('')
            ->action('Track Order Status', $trackingUrl)
            ->line('')
            ->line('Thank you for shopping with Pearls By HM!')
            ->salutation('Warm regards, Pearls By HM Team');
    }
}
