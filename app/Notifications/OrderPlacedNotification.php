<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $email;

    public function __construct($order, $email)
    {
        $this->order = $order;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $order = $this->order;

        // ✅ Build the dynamic tracking link
        $trackingUrl = url('/track-my-order?tracking_id=' . $order->tracking_id);

        return (new MailMessage)
            ->subject('Your Order Has Been Placed Successfully!')
            ->greeting('Hello ' . trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? 'Customer')) . ',')
            ->line('Thank you for your order! Here are your order details:')
            ->line('**Order Summary**')
            ->line('Tracking ID: ' . $order->tracking_id)
            ->line('Placed On: ' . $order->created_at->format('d M Y, h:i A'))
            ->line('Total Products: ' . $order->total_products)
            ->line('Total Items: ' . $order->total_items)
            ->line('Subtotal: Rs.' . number_format($order->subtotal, 2))
            ->line('Shipping: Rs.' . number_format($order->shipping, 2))
            ->line('Total: Rs.' . number_format($order->total, 2))
            ->line('')
            ->action('Track Order Status', $trackingUrl)
            ->line('')
            ->line('**Shipping Address**')
            ->line(($order->first_name ?? '') . ' ' . ($order->last_name ?? ''))
            ->line('Phone: ' . ($order->phone ?? 'N/A'))
            ->line('Address: ' . ($order->address ?? 'N/A'))
            ->when($order->postal_code, fn($msg) => $msg->line('Postal Code: ' . $order->postal_code))
            ->when($order->landmark, fn($msg) => $msg->line('Landmark: ' . $order->landmark))
            ->line('')
            ->line('We’ll notify you about your order status soon...')
            ->salutation('Best regards, ' . config('app.name'));
    }
}
