<?php

namespace App\Console\Commands;

use App\Notifications\NewOrderPlacedAdminNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendAdminOrderMail extends Command
{
    protected $signature = 'send:admin-order-mail {orderData}';
    protected $description = 'Send admin new order notification in background';

    public function handle()
    {
        try {
            $order = json_decode(base64_decode($this->argument('orderData')));
            $adminEmails = DB::table('admins')->pluck('email')->toArray();

            if (!empty($adminEmails)) {
                Notification::route('mail', $adminEmails)
                    ->notify(new NewOrderPlacedAdminNotification((object) $order));
            }

            $this->info('Admin order email sent successfully!');
        } catch (\Throwable $e) {
            Log::error('Failed to send admin email in background: ' . $e->getMessage());
        }
    }
}
