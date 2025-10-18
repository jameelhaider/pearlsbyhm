<?php

namespace App\Console\Commands;

use App\Notifications\OrderPlacedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendUserOrderMail extends Command
{
    protected $signature = 'send:user-order-mail {data}';
    protected $description = 'Send order placed email to user in background';

    public function handle()
    {
        try {
            $payload = json_decode(base64_decode($this->argument('data')), true);
            $order = (object) $payload['order'];
            $email = $payload['email'];

            Notification::route('mail', $email)
                ->notify(new OrderPlacedNotification($order, $email));

            $this->info('User order email sent successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to send user email in background: ' . $e->getMessage());
        }
    }
}
