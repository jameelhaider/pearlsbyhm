<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderCancelledUserNotification;
use App\Notifications\OrderDeliveredUserNotification;
use App\Notifications\OrderInprocessUserNotification;
use App\Notifications\OrderPackedUserNotification;
use App\Notifications\OrderSentUserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class OrdersController extends Controller
{
    public function index($status)
    {
        if ($status == 'pending') {
            $orders = DB::table('orders')->where('status', 'Pending')->paginate(500);
        }
        if ($status == 'in-process') {
            $orders = DB::table('orders')->where('status', 'In Process')->paginate(500);
        }
        if ($status == 'packed') {
            $orders = DB::table('orders')->where('status', 'Packed, Ready To Ship')->paginate(500);
        }
        if ($status == 'sent') {
            $orders = DB::table('orders')->where('status', 'Sent To Parcel Delivered Company')->paginate(500);
        }
        if ($status == 'delivered') {
            $orders = DB::table('orders')->where('status', 'Delivered')->paginate(500);
        }
        if ($status == 'cancelled') {
            $orders = DB::table('orders')->where('status', 'Cancelled')->paginate(500);
        }
        return view('admin.orders.index', compact('orders'));
    }


    public function details($id)
    {
        $order = DB::table('orders')
            ->where('id', $id)
            ->first();
        $order_items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.*',
                'products.image as product_image',
                'products.url as url',
            )
            ->where('order_items.order_id', $order->id)
            ->get();
        return view('admin.orders.details', compact('order', 'order_items'));
    }



    public function updatestatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();
        try {
            $email = $order->email;
            if ($status == 'In Process') {
                Notification::route('mail', $email)
                    ->notify(
                        (new OrderInProcessUserNotification($order))
                            ->delay(now()->addMinute())
                    );
            } elseif ($status == 'Packed, Ready To Ship') {
                Notification::route('mail', $email)
                    ->notify(
                        (new OrderPackedUserNotification($order))
                            ->delay(now()->addMinute())
                    );
            } elseif ($status == 'Sent To Parcel Delivered Company') {
                Notification::route('mail', $email)
                    ->notify(
                        (new OrderSentUserNotification($order))
                            ->delay(now()->addMinute())
                    );
            } elseif ($status == 'Delivered') {
                Notification::route('mail', $email)
                    ->notify(
                        (new OrderDeliveredUserNotification($order))
                            ->delay(now()->addMinute())
                    );
            } elseif ($status == 'Cancelled') {
                Notification::route('mail', $email)
                    ->notify(
                        (new OrderCancelledUserNotification($order))
                            ->delay(now()->addMinute())
                    );
            }
        } catch (\Exception $e) {
            Log::error('Order email failed: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Order status has been updated and user notified successfully.');
    }
}
