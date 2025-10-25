<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $guestId = getOrCreateGuestId();
        $cartQuery = DB::table('carts');
        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('guest_id', $guestId);
        }
        $cart = $cartQuery->first();
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select(
                'products.image as image',
                'products.name as name',
                'products.price as price',
                'cart_items.id as cart_item_id',
                'cart_items.qty as qty'
            )
            ->where('cart_id', $cart->id)
            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->qty;
        });
        $shipping = $subtotal >= shipping_free_on() ? 0 : shipping_charges();
        $total = $subtotal + $shipping;
        $addresses = $userId
            ? DB::table('addresses')->where('user_id', $userId)->get()
            : collect();
        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'));
    }


    public function store(Request $request)
    {
        $userId  = Auth::id();
        $guestId = getOrCreateGuestId();
        $addresses = $userId ? DB::table('addresses')->where('user_id', $userId)->get() : collect();
        try {
            if ($userId && $addresses->count() > 0) {
                if ($request->address_method === 'Using Different Address') {
                    $this->validateAddress($request);
                    DB::beginTransaction();
                    try {
                        $order = $this->createOrderFromRequest($request, $userId, $guestId);
                        if ($request->save_for_later == 'on') {
                            $this->saveAddress($request, $userId);
                        }
                        $this->moveCartItemsToOrder($order, $userId, $guestId);
                        try {
                            Notification::route('mail', $request->email)
                                ->notify((new \App\Notifications\OrderPlacedNotification($order, $request->email))
                                    ->delay(now()->addMinute()));
                        } catch (\Throwable $n) {
                            Log::error('Customer notification failed: ' . $n->getMessage());
                        }
                        $this->notifyAdmins($order);
                        DB::commit();
                        return redirect()->route('welcome')->with('success', 'Order placed successfully!');
                    } catch (\Throwable $e) {
                        DB::rollBack();
                        Log::error('Order placement (different address) failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                        return redirect()->back()->withInput()->with('error', 'Order failed: ' . $e->getMessage());
                    }
                }
                $request->validate(['selected_address' => 'required']);
                $selected = DB::table('addresses')->where('id', $request->selected_address)->first();
                DB::beginTransaction();
                try {
                    $order = $this->createOrderFromAddress($selected, $userId, $guestId);
                    $this->moveCartItemsToOrder($order, $userId, $guestId);
                    try {
                        Notification::route('mail', Auth::user()->email)
                            ->notify((new \App\Notifications\OrderPlacedNotification($order, Auth::user()->email))
                                ->delay(now()->addMinute()));
                    } catch (\Throwable $n) {
                        Log::error('Customer notification failed: ' . $n->getMessage());
                    }
                    $this->notifyAdmins($order);
                    DB::commit();
                    return redirect()->route('welcome')->with('success', 'Order placed successfully!');
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error('Order placement (saved address) failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    return redirect()->back()->withInput()->with('error', 'Order failed: ' . $e->getMessage());
                }
            }
            $this->validateAddress($request);
            DB::beginTransaction();
            try {
                $order = $this->createOrderFromRequest($request, $userId, $guestId);
                if ($request->save_for_later == 'on' && $userId) {
                    $this->saveAddress($request, $userId);
                }
                $this->moveCartItemsToOrder($order, $userId, $guestId);
                try {
                    Notification::route('mail', $request->email)
                        ->notify((new \App\Notifications\OrderPlacedNotification($order, $request->email))
                            ->delay(now()->addMinute()));
                } catch (\Throwable $n) {
                    Log::error('Customer notification failed: ' . $n->getMessage());
                }
                $this->notifyAdmins($order);
                DB::commit();
                return redirect()->route('welcome')->with('success', 'Order placed successfully!');
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('Order placement (guest/no saved) failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                return redirect()->back()->withInput()->with('error', 'Order failed: ' . $e->getMessage());
            }
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $e) {
            Log::error('Checkout.store top-level error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Something went wrong while placing your order: ' . $e->getMessage());
        }
    }

    private function notifyAdmins($order)
    {
        try {
            $adminEmails = DB::table('admins')->pluck('email')->toArray();
            if (!empty($adminEmails)) {
                Notification::route('mail', $adminEmails)
                    ->notify((new \App\Notifications\NewOrderPlacedAdminNotification($order))
                        ->delay(now()->addMinute()));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send admin notification: ' . $e->getMessage());
        }
    }

    private function validateAddress(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name'  => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'email'      => ['required', 'string', 'email', 'max:255'],
            'address'    => ['required', 'string', 'max:500'],
            'city'       => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'phone'      => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/'],
            'postal_code' => ['nullable', 'regex:/^[0-9]{5}$/'],
            'landmark'   => ['nullable', 'string', 'max:255'],
        ], [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex'  => 'Last name can only contain letters and spaces.',
            'city.regex'       => 'City name can only contain letters and spaces.',
            'phone.regex'      => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
            'postal_code.regex' => 'Postal code must be a 5-digit number.',
            'email.required'   => 'Email address is required.',
            'email.email'      => 'Please enter a valid email address.',
        ]);
    }

    private function getCart($userId, $guestId)
    {
        $cart = DB::table('carts')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('guest_id', $guestId))
            ->first();
        if (!$cart) {
            throw new \Exception('Your cart is empty.');
        }
        $items = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select('cart_items.qty', 'products.id as product_id', 'products.price', 'products.name')
            ->where('cart_items.cart_id', $cart->id)
            ->get();
        if ($items->isEmpty()) {
            throw new \Exception('Your cart is empty.');
        }
        $subtotal = $items->sum(fn($i) => $i->price * $i->qty);
        $shipping = $subtotal >= shipping_free_on() ? 0 : shipping_charges();
        return compact('cart', 'items', 'subtotal', 'shipping');
    }

    private function createOrderFromRequest(Request $request, $userId, $guestId)
    {
        extract($this->getCart($userId, $guestId));
        $order = new Order();
        $order->fill([
            'user_id'        => $userId,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'address'        => $request->address,
            'city'           => $request->city,
            'phone'          => $request->phone,
            'postal_code'    => $request->postal_code ?? null,
            'landmark'       => $request->landmark ?? null,
            'subtotal'       => $subtotal,
            'email'          => $request->email,
            'shipping'       => $shipping,
            'tracking_id'    => 'TRK-' . strtoupper(Str::random(6)),
            'url'            => 'order' . '-r' . rand(1000, 9999) . '-t' . time(),
            'total'          => $subtotal + $shipping,
            'status'         => 'Pending',
            'total_products' => $items->count(),
            'total_items'    => $items->sum('qty'),
        ]);
        $order->save();
        return $order;
    }

    private function createOrderFromAddress($address, $userId, $guestId)
    {
        extract($this->getCart($userId, $guestId));
        $order = new Order();
        $order->fill([
            'user_id'        => $userId,
            'first_name'     => $address->first_name,
            'last_name'      => $address->last_name,
            'address'        => $address->address,
            'city'           => $address->city,
            'phone'          => $address->phone,
            'postal_code'    => $address->postal_code,
            'landmark'       => $address->landmark,
            'email'          => $address->email ?? (Auth::check() ? Auth::user()->email : null),
            'subtotal'       => $subtotal,
            'shipping'       => $shipping,
            'tracking_id'    => 'TRK-' . strtoupper(Str::random(6)),
            'url'            => 'order' . '-r' . rand(1000, 9999) . '-t' . time(),
            'total'          => $subtotal + $shipping,
            'status'         => 'Pending',
            'total_products' => $items->count(),
            'total_items'    => $items->sum('qty'),
        ]);
        $order->save();
        return $order;
    }

    private function moveCartItemsToOrder($order, $userId, $guestId)
    {
        extract($this->getCart($userId, $guestId));

        foreach ($items as $item) {
            DB::table('order_items')->insert([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'name'       => $item->name,
                'price'      => $item->price,
                'total'      => $item->price * $item->qty,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('cart_items')->where('cart_id', $cart->id)->delete();
        DB::table('carts')->where('id', $cart->id)->delete();
    }

    private function saveAddress(Request $request, $userId)
    {
        Address::create([
            'user_id'     => $userId,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'address'     => $request->address,
            'city'        => $request->city,
            'url'         =>  'address' . '-r' . rand(1000, 9999) . '-t' . time(),
            'phone'       => $request->phone,
            'postal_code' => $request->postal_code ?? null,
            'landmark'    => $request->landmark ?? null,
        ]);
    }




    public function trackmyorder(Request $request)
    {
        $order = null;
        if ($request->filled('tracking_id')) {
            $order = DB::table('orders')
                ->where('tracking_id', $request->tracking_id)
                ->first();
        }
        return view('orders.trackmyorder', compact('order'));
    }
}
