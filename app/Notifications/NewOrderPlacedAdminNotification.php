<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderPlacedAdminNotification extends Notification implements ShouldQueue
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
        $order = $this->order;

        return (new MailMessage)
            ->subject('🛒 New Order Placed!')
            ->greeting('Hello Admin,')
            ->line('A new order has just been placed!')
            ->line('**Order Details**')
            ->line('Customer: ' . $order->first_name . ' ' . $order->last_name)
            ->line('Total Products: ' . $order->total_products)
            ->line('Total Items: ' . $order->total_items)
            ->line('Total Amount: Rs.' . number_format($order->total, 2))
            ->line('Placed On: ' . $order->created_at->format('d M Y, h:i A'))
            ->salutation('Best regards, ' . config('app.name'));
    }
}
