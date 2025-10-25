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

    // public function store(Request $request)
    // {
    //     if (Auth::check()) {
    //         $addresses = DB::table('addresses')
    //             ->where('user_id', Auth::id())
    //             ->get();
    //     }

    //     if (Auth::check() && $addresses->count() > 0) {
    //         if ($request->address_method == 'Using Different Address') {
    //             $request->validate([
    //                 'first_name' => [
    //                     'required',
    //                     'string',
    //                     'max:255',
    //                     'regex:/^[A-Za-z\s]+$/',
    //                 ],
    //                 'last_name' => [
    //                     'required',
    //                     'string',
    //                     'max:255',
    //                     'regex:/^[A-Za-z\s]+$/',
    //                 ],
    //                 'address' => [
    //                     'required',
    //                     'string',
    //                     'max:500',
    //                 ],
    //                 'city' => [
    //                     'required',
    //                     'string',
    //                     'max:255',
    //                     'regex:/^[A-Za-z\s]+$/',
    //                 ],
    //                 'phone' => [
    //                     'required',
    //                     'regex:/^03[0-9]{2}-[0-9]{7}$/',
    //                 ],
    //                 'postal_code' => [
    //                     'nullable',
    //                     'regex:/^[0-9]{5}$/',
    //                 ],
    //                 'landmark' => [
    //                     'nullable',
    //                     'string',
    //                     'max:255',
    //                 ],
    //             ], [
    //                 'first_name.regex' => 'First name can only contain letters and spaces.',
    //                 'last_name.regex' => 'Last name can only contain letters and spaces.',
    //                 'city.regex' => 'City name can only contain letters and spaces.',
    //                 'phone.regex' => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
    //                 'postal_code.regex' => 'Postal code must be a 5-digit number.',
    //             ]);


    //             $userId = Auth::id();
    //             $guestId = getOrCreateGuestId();
    //             $cartQuery = DB::table('carts');
    //             if ($userId) {
    //                 $cartQuery->where('user_id', $userId);
    //             } else {
    //                 $cartQuery->where('guest_id', $guestId);
    //             }
    //             $cart = $cartQuery->first();
    //             if (!$cart) {
    //                 return redirect()->back()->with('error', 'Your cart is empty.');
    //             }
    //             $cartItems = DB::table('cart_items')
    //                 ->join('products', 'cart_items.product_id', '=', 'products.id')
    //                 ->select(
    //                     'cart_items.qty as qty',
    //                     'products.id as product_id',
    //                     'products.price as price',
    //                     'products.name as name'
    //                 )
    //                 ->where('cart_items.cart_id', $cart->id)
    //                 ->get();
    //             if ($cartItems->isEmpty()) {
    //                 return redirect()->back()->with('error', 'Your cart is empty.');
    //             }
    //             $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
    //             $shipping = $subtotal >= 2000 ? 0 : 260;
    //             $total = $subtotal + $shipping;
    //             $total_products = $cartItems->count();
    //             $total_items = $cartItems->sum('qty');
    //             $order = new Order();
    //             $order->user_id = $userId ?? null;
    //             $order->first_name = $request->first_name;
    //             $order->last_name = $request->last_name;
    //             $order->address = $request->address;
    //             $order->city = $request->city;
    //             $order->phone = $request->phone;
    //             $order->postal_code = $request->postal_code ?? null;
    //             $order->landmark = $request->landmark ?? null;
    //             $order->subtotal = $subtotal;
    //             $order->shipping = $shipping;
    //             $order->total = $total;
    //             $order->status = 'Pending';
    //             $order->total_products = $total_products;
    //             $order->total_items = $total_items;
    //             $order->save();
    //             if ($request->save_for_later == 'on' && Auth::check()) {
    //                 $address = new Address();
    //                 $address->user_id = Auth::id();
    //                 $address->first_name = $request->first_name;
    //                 $address->last_name = $request->last_name;
    //                 $address->address = $request->address;
    //                 $address->city = $request->city;
    //                 $address->phone = $request->phone;
    //                 $address->postal_code = $request->postal_code ?? null;
    //                 $address->landmark = $request->landmark ?? null;
    //                 $address->save();
    //             }

    //             foreach ($cartItems as $item) {
    //                 DB::table('order_items')->insert([
    //                     'order_id'    => $order->id,
    //                     'product_id'  => $item->product_id,
    //                     'qty'         => $item->qty,
    //                     'name'        => $item->name,
    //                     'price'       => $item->price,
    //                     'total'       => $item->price * $item->qty,
    //                     'created_at'  => now(),
    //                     'updated_at'  => now(),
    //                 ]);
    //             }
    //             DB::table('cart_items')->where('cart_id', $cart->id)->delete();
    //             DB::table('carts')->where('id', $cart->id)->delete();
    //             return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    //         } else {



    //             $request->validate([
    //                 'selected_address' => [
    //                     'required',
    //                 ]
    //             ]);


    //             $userId = Auth::id();
    //             $guestId = getOrCreateGuestId();
    //             $cartQuery = DB::table('carts');
    //             if ($userId) {
    //                 $cartQuery->where('user_id', $userId);
    //             } else {
    //                 $cartQuery->where('guest_id', $guestId);
    //             }
    //             $cart = $cartQuery->first();
    //             if (!$cart) {
    //                 return redirect()->back()->with('error', 'Your cart is empty.');
    //             }
    //             $cartItems = DB::table('cart_items')
    //                 ->join('products', 'cart_items.product_id', '=', 'products.id')
    //                 ->select(
    //                     'cart_items.qty as qty',
    //                     'products.id as product_id',
    //                     'products.price as price',
    //                     'products.name as name'
    //                 )
    //                 ->where('cart_items.cart_id', $cart->id)
    //                 ->get();
    //             if ($cartItems->isEmpty()) {
    //                 return redirect()->back()->with('error', 'Your cart is empty.');
    //             }
    //             $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
    //             $shipping = $subtotal >= 2000 ? 0 : 260;
    //             $total = $subtotal + $shipping;
    //             $total_products = $cartItems->count();
    //             $total_items = $cartItems->sum('qty');
    //             $address=DB::table('addresses')->where('id',$request->selected_address)
    //             ->first();
    //             $order = new Order();
    //             $order->user_id = $userId ?? null;
    //             $order->first_name = $address->first_name;
    //             $order->last_name = $address->last_name;
    //             $order->address = $address->address;
    //             $order->city = $address->city;
    //             $order->phone = $address->phone;
    //             $order->postal_code = $address->postal_code ?? null;
    //             $order->landmark = $address->landmark ?? null;
    //             $order->subtotal = $subtotal;
    //             $order->shipping = $shipping;
    //             $order->total = $total;
    //             $order->status = 'Pending';
    //             $order->total_products = $total_products;
    //             $order->total_items = $total_items;
    //             $order->save();
    //             if ($request->save_for_later == 'on' && Auth::check()) {
    //                 $address = new Address();
    //                 $address->user_id = Auth::id();
    //                 $address->first_name = $request->first_name;
    //                 $address->last_name = $request->last_name;
    //                 $address->address = $request->address;
    //                 $address->city = $request->city;
    //                 $address->phone = $request->phone;
    //                 $address->postal_code = $request->postal_code ?? null;
    //                 $address->landmark = $request->landmark ?? null;
    //                 $address->save();
    //             }

    //             foreach ($cartItems as $item) {
    //                 DB::table('order_items')->insert([
    //                     'order_id'    => $order->id,
    //                     'product_id'  => $item->product_id,
    //                     'qty'         => $item->qty,
    //                     'name'        => $item->name,
    //                     'price'       => $item->price,
    //                     'total'       => $item->price * $item->qty,
    //                     'created_at'  => now(),
    //                     'updated_at'  => now(),
    //                 ]);
    //             }
    //             DB::table('cart_items')->where('cart_id', $cart->id)->delete();
    //             DB::table('carts')->where('id', $cart->id)->delete();
    //             return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    //         }
    //     } else {
    //         $request->validate([
    //             'first_name' => [
    //                 'required',
    //                 'string',
    //                 'max:255',
    //                 'regex:/^[A-Za-z\s]+$/',
    //             ],
    //             'last_name' => [
    //                 'required',
    //                 'string',
    //                 'max:255',
    //                 'regex:/^[A-Za-z\s]+$/',
    //             ],
    //             'address' => [
    //                 'required',
    //                 'string',
    //                 'max:500',
    //             ],
    //             'city' => [
    //                 'required',
    //                 'string',
    //                 'max:255',
    //                 'regex:/^[A-Za-z\s]+$/',
    //             ],
    //             'phone' => [
    //                 'required',
    //                 'regex:/^03[0-9]{2}-[0-9]{7}$/',
    //             ],
    //             'postal_code' => [
    //                 'nullable',
    //                 'regex:/^[0-9]{5}$/',
    //             ],
    //             'landmark' => [
    //                 'nullable',
    //                 'string',
    //                 'max:255',
    //             ],
    //         ], [
    //             'first_name.regex' => 'First name can only contain letters and spaces.',
    //             'last_name.regex' => 'Last name can only contain letters and spaces.',
    //             'city.regex' => 'City name can only contain letters and spaces.',
    //             'phone.regex' => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
    //             'postal_code.regex' => 'Postal code must be a 5-digit number.',
    //         ]);


    //         $userId = Auth::id();
    //         $guestId = getOrCreateGuestId();
    //         $cartQuery = DB::table('carts');
    //         if ($userId) {
    //             $cartQuery->where('user_id', $userId);
    //         } else {
    //             $cartQuery->where('guest_id', $guestId);
    //         }
    //         $cart = $cartQuery->first();
    //         if (!$cart) {
    //             return redirect()->back()->with('error', 'Your cart is empty.');
    //         }
    //         $cartItems = DB::table('cart_items')
    //             ->join('products', 'cart_items.product_id', '=', 'products.id')
    //             ->select(
    //                 'cart_items.qty as qty',
    //                 'products.id as product_id',
    //                 'products.price as price',
    //                 'products.name as name'
    //             )
    //             ->where('cart_items.cart_id', $cart->id)
    //             ->get();
    //         if ($cartItems->isEmpty()) {
    //             return redirect()->back()->with('error', 'Your cart is empty.');
    //         }
    //         $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
    //         $shipping = $subtotal >= 2000 ? 0 : 260;
    //         $total = $subtotal + $shipping;
    //         $total_products = $cartItems->count();
    //         $total_items = $cartItems->sum('qty');
    //         $order = new Order();
    //         $order->user_id = $userId ?? null;
    //         $order->first_name = $request->first_name;
    //         $order->last_name = $request->last_name;
    //         $order->address = $request->address;
    //         $order->city = $request->city;
    //         $order->phone = $request->phone;
    //         $order->postal_code = $request->postal_code ?? null;
    //         $order->landmark = $request->landmark ?? null;
    //         $order->subtotal = $subtotal;
    //         $order->shipping = $shipping;
    //         $order->total = $total;
    //         $order->status = 'Pending';
    //         $order->total_products = $total_products;
    //         $order->total_items = $total_items;
    //         $order->save();
    //         if ($request->save_for_later == 'on' && Auth::check()) {
    //             $address = new Address();
    //             $address->user_id = Auth::id();
    //             $address->first_name = $request->first_name;
    //             $address->last_name = $request->last_name;
    //             $address->address = $request->address;
    //             $address->city = $request->city;
    //             $address->phone = $request->phone;
    //             $address->postal_code = $request->postal_code ?? null;
    //             $address->landmark = $request->landmark ?? null;
    //             $address->save();
    //         }

    //         foreach ($cartItems as $item) {
    //             DB::table('order_items')->insert([
    //                 'order_id'    => $order->id,
    //                 'product_id'  => $item->product_id,
    //                 'qty'         => $item->qty,
    //                 'name'        => $item->name,
    //                 'price'       => $item->price,
    //                 'total'       => $item->price * $item->qty,
    //                 'created_at'  => now(),
    //                 'updated_at'  => now(),
    //             ]);
    //         }
    //         DB::table('cart_items')->where('cart_id', $cart->id)->delete();
    //         DB::table('carts')->where('id', $cart->id)->delete();
    //         return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    //     }
    // }



    // public function store(Request $request)
    // {
    //     $userId = Auth::id();
    //     $guestId = getOrCreateGuestId();
    //     $addresses = $userId ? DB::table('addresses')->where('user_id', $userId)->get() : collect();
    //     if ($userId && $addresses->count() > 0) {
    //         if ($request->address_method === 'Using Different Address') {
    //             $this->validateAddress($request);
    //             $order = $this->createOrderFromRequest($request, $userId, $guestId);
    //             if ($request->save_for_later == 'on') $this->saveAddress($request, $userId);
    //             $this->moveCartItemsToOrder($order, $userId, $guestId);
    //             return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    //         }
    //         $request->validate(['selected_address' => 'required']);
    //         $selected = DB::table('addresses')->where('id', $request->selected_address)->first();
    //         $order = $this->createOrderFromAddress($selected, $userId, $guestId);
    //         $this->moveCartItemsToOrder($order, $userId, $guestId);
    //         return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    //     }
    //     $this->validateAddress($request);
    //     $order = $this->createOrderFromRequest($request, $userId, $guestId);
    //     if ($request->save_for_later == 'on' && $userId) $this->saveAddress($request, $userId);
    //     $this->moveCartItemsToOrder($order, $userId, $guestId);
    //     return redirect()->route('welcome')->with('success', 'Order placed successfully!');
    // }

    // private function validateAddress(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
    //         'last_name'  => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
    //         'email'      => ['required', 'string', 'email', 'max:255'],
    //         'address'    => ['required', 'string', 'max:500'],
    //         'city'       => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
    //         'phone'      => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/'],
    //         'postal_code' => ['nullable', 'regex:/^[0-9]{5}$/'],
    //         'landmark'   => ['nullable', 'string', 'max:255'],
    //     ], [
    //         'first_name.regex' => 'First name can only contain letters and spaces.',
    //         'last_name.regex'  => 'Last name can only contain letters and spaces.',
    //         'city.regex'       => 'City name can only contain letters and spaces.',
    //         'phone.regex'      => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
    //         'postal_code.regex' => 'Postal code must be a 5-digit number.',
    //         'email.required'   => 'Email address is required.',
    //         'email.email'      => 'Please enter a valid email address.',
    //     ]);
    // }


    // private function getCart($userId, $guestId)
    // {
    //     $cart = DB::table('carts')
    //         ->when($userId, fn($q) => $q->where('user_id', $userId))
    //         ->when(!$userId, fn($q) => $q->where('guest_id', $guestId))
    //         ->first();

    //     if (!$cart) abort(redirect()->back()->with('error', 'Your cart is empty.'));

    //     $items = DB::table('cart_items')
    //         ->join('products', 'cart_items.product_id', '=', 'products.id')
    //         ->select('cart_items.qty', 'products.id as product_id', 'products.price', 'products.name')
    //         ->where('cart_items.cart_id', $cart->id)
    //         ->get();
    //     if ($items->isEmpty()) abort(redirect()->back()->with('error', 'Your cart is empty.'));
    //     $subtotal = $items->sum(fn($i) => $i->price * $i->qty);
    //     $shipping = $subtotal >= 2000 ? 0 : 260;
    //     return compact('cart', 'items', 'subtotal', 'shipping');
    // }

    // private function createOrderFromRequest(Request $request, $userId, $guestId)
    // {
    //     extract($this->getCart($userId, $guestId));
    //     $order = new Order();
    //     $order->fill([
    //         'user_id'        => $userId,
    //         'first_name'     => $request->first_name,
    //         'last_name'      => $request->last_name,
    //         'address'        => $request->address,
    //         'city'           => $request->city,
    //         'phone'          => $request->phone,
    //         'postal_code'    => $request->postal_code ?? null,
    //         'landmark'       => $request->landmark ?? null,
    //         'subtotal'       => $subtotal,
    //         'email'       => $request->email,
    //         'shipping'       => $shipping,
    //         'tracking_id' => 'TRK-' . strtoupper(Str::random(6)),
    //         'url'       => 'order' . '-r' . rand(1000, 9999) . '-t' . time(),
    //         'total'          => $subtotal + $shipping,
    //         'status'         => 'Pending',
    //         'total_products' => $items->count(),
    //         'total_items'    => $items->sum('qty'),
    //     ]);
    //     $order->save();
    //     return $order;
    // }

    // private function createOrderFromAddress($address, $userId, $guestId)
    // {
    //     extract($this->getCart($userId, $guestId));
    //     $order = new Order();
    //     $order->fill([
    //         'user_id'        => $userId,
    //         'first_name'     => $address->first_name,
    //         'last_name'      => $address->last_name,
    //         'address'        => $address->address,
    //         'city'           => $address->city,
    //         'phone'          => $address->phone,
    //         'postal_code'    => $address->postal_code,
    //         'landmark'       => $address->landmark,
    //         'email'       => Auth::user()->email,
    //         'subtotal'       => $subtotal,
    //         'tracking_id' => 'TRK-' . strtoupper(Str::random(6)),
    //         'url'       => 'order' . '-r' . rand(1000, 9999) . '-t' . time(),
    //         'shipping'       => $shipping,
    //         'total'          => $subtotal + $shipping,
    //         'status'         => 'Pending',
    //         'total_products' => $items->count(),
    //         'total_items'    => $items->sum('qty'),
    //     ]);
    //     $order->save();
    //     return $order;
    // }

    // private function moveCartItemsToOrder($order, $userId, $guestId)
    // {
    //     extract($this->getCart($userId, $guestId));
    //     foreach ($items as $item) {
    //         DB::table('order_items')->insert([
    //             'order_id'   => $order->id,
    //             'product_id' => $item->product_id,
    //             'qty'        => $item->qty,
    //             'name'       => $item->name,
    //             'price'      => $item->price,
    //             'total'      => $item->price * $item->qty,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }
    //     DB::table('cart_items')->where('cart_id', $cart->id)->delete();
    //     DB::table('carts')->where('id', $cart->id)->delete();
    // }

    // private function saveAddress(Request $request, $userId)
    // {
    //     Address::create([
    //         'user_id'     => $userId,
    //         'first_name'  => $request->first_name,
    //         'last_name'   => $request->last_name,
    //         'address'     => $request->address,
    //         'city'        => $request->city,
    //         'phone'       => $request->phone,
    //         'postal_code' => $request->postal_code ?? null,
    //         'landmark'    => $request->landmark ?? null,
    //     ]);
    // }





    public function store(Request $request)
    {
        $userId = Auth::id();
        $guestId = getOrCreateGuestId();
        $addresses = $userId ? DB::table('addresses')->where('user_id', $userId)->get() : collect();
        try {
            if ($userId && $addresses->count() > 0) {
                if ($request->address_method === 'Using Different Address') {
                    $this->validateAddress($request);
                    $order = $this->createOrderFromRequest($request, $userId, $guestId);
                    if ($request->save_for_later == 'on') {
                        $this->saveAddress($request, $userId);
                    }
                    $this->moveCartItemsToOrder($order, $userId, $guestId);
                    try {
                        Notification::route('mail', $request->email)
                            ->notify((new OrderPlacedNotification($order, $request->email)));
                    } catch (\Throwable $e) {
                        Log::error('Failed to schedule order email to customer: ' . $e->getMessage());
                    }
                    $this->notifyAdmins($order);
                    return redirect()->route('welcome')->with('success', 'Order placed successfully!');
                }
                $request->validate(['selected_address' => 'required']);
                $selected = DB::table('addresses')->where('id', $request->selected_address)->first();
                $order = $this->createOrderFromAddress($selected, $userId, $guestId);
                $this->moveCartItemsToOrder($order, $userId, $guestId);
                try {
                    Notification::route('mail', Auth::user()->email)
                        ->notify((new OrderPlacedNotification($order, Auth::user()->email)));
                } catch (\Throwable $e) {
                    Log::error('Failed to schedule order email to logged-in customer: ' . $e->getMessage());
                }
                $this->notifyAdmins($order);
                return redirect()->route('welcome')->with('success', 'Order placed successfully!');
            }
            $this->validateAddress($request);
            $order = $this->createOrderFromRequest($request, $userId, $guestId);
            if ($request->save_for_later == 'on' && $userId) {
                $this->saveAddress($request, $userId);
            }
            $this->moveCartItemsToOrder($order, $userId, $guestId);
            try {
                Notification::route('mail', $request->email)
                    ->notify((new OrderPlacedNotification($order, $request->email)));
            } catch (\Throwable $e) {
                Log::error('Failed to schedule order email to guest: ' . $e->getMessage());
            }
            $this->notifyAdmins($order);
            return redirect()->route('welcome')->with('success', 'Order placed successfully!');
        } catch (\Throwable $e) {
            Log::error('Order placement failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while placing your order. Please try again.');
        }
    }



    private function notifyAdmins($order)
    {
        try {
            $adminEmails = DB::table('admins')->pluck('email')->toArray();
            if (!empty($adminEmails)) {
                Notification::route('mail', $adminEmails)
                    ->notify((new \App\Notifications\NewOrderPlacedAdminNotification($order)));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to schedule admin order notification: ' . $e->getMessage());
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

        if (!$cart) abort(redirect()->back()->with('error', 'Your cart is empty.'));

        $items = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select('cart_items.qty', 'products.id as product_id', 'products.price', 'products.name')
            ->where('cart_items.cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) abort(redirect()->back()->with('error', 'Your cart is empty.'));

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
            'email'          => Auth::user()->email,
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
