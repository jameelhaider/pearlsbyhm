<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderInProcessUserNotification extends Notification implements ShouldQueue
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
            ->subject('Your Order is Now Being Processed 🛠️')
            ->greeting('Hello ' . $this->order->first_name . ' ' . $this->order->last_name . ',')
            ->line('We’ve started processing your order **#' . $this->order->tracking_id . '**.')
            ->line('Our team is preparing your items for packaging. You’ll receive another update once it’s ready to ship.')
            ->line('')
            ->action('Track Order Status', $trackingUrl)
            ->line('')
            ->line('Thank you for choosing '.site_name().'!')
            ->salutation('Warm regards, '.site_name().' Team');
    }
}
