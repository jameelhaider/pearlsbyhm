<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPackedUserNotification extends Notification implements ShouldQueue
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
            ->subject('Your Order is Packed & Ready to Ship 📦')
            ->greeting('Hello ' . $this->order->first_name . ' ' . $this->order->last_name . ',')
            ->line('Good news! Your order **#' . $this->order->tracking_id . '** has been packed and is ready for shipping.')
            ->line('We’ll notify you as soon as it’s handed over to our delivery partner.')
            ->line('')
            ->action('Track Order Status', $trackingUrl)
            ->line('')
            ->line('Thank you for your patience and trust in Pearls By HM!')
            ->salutation('Warm regards, Pearls By HM Team');
    }
}
