<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $shipping = $subtotal >= 2000 ? 0 : 260;
        $total = $subtotal + $shipping;

        $addresses = $userId
            ? DB::table('addresses')->where('user_id', $userId)->get()
            : collect();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'));
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            $addresses = DB::table('addresses')
                ->where('user_id', Auth::id())
                ->get();
        }

        if (Auth::check() && $addresses->count() > 0) {
            if ($request->address_method == 'Using Different Address') {
                $request->validate([
                    'first_name' => [
                        'required',
                        'string',
                        'max:255',
                        'regex:/^[A-Za-z\s]+$/',
                    ],
                    'last_name' => [
                        'required',
                        'string',
                        'max:255',
                        'regex:/^[A-Za-z\s]+$/',
                    ],
                    'address' => [
                        'required',
                        'string',
                        'max:500',
                    ],
                    'city' => [
                        'required',
                        'string',
                        'max:255',
                        'regex:/^[A-Za-z\s]+$/',
                    ],
                    'phone' => [
                        'required',
                        'regex:/^03[0-9]{2}-[0-9]{7}$/',
                    ],
                    'postal_code' => [
                        'nullable',
                        'regex:/^[0-9]{5}$/',
                    ],
                    'landmark' => [
                        'nullable',
                        'string',
                        'max:255',
                    ],
                ], [
                    'first_name.regex' => 'First name can only contain letters and spaces.',
                    'last_name.regex' => 'Last name can only contain letters and spaces.',
                    'city.regex' => 'City name can only contain letters and spaces.',
                    'phone.regex' => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
                    'postal_code.regex' => 'Postal code must be a 5-digit number.',
                ]);


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
                    return redirect()->back()->with('error', 'Your cart is empty.');
                }
                $cartItems = DB::table('cart_items')
                    ->join('products', 'cart_items.product_id', '=', 'products.id')
                    ->select(
                        'cart_items.qty as qty',
                        'products.id as product_id',
                        'products.price as price',
                        'products.name as name'
                    )
                    ->where('cart_items.cart_id', $cart->id)
                    ->get();
                if ($cartItems->isEmpty()) {
                    return redirect()->back()->with('error', 'Your cart is empty.');
                }
                $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
                $shipping = $subtotal >= 2000 ? 0 : 260;
                $total = $subtotal + $shipping;
                $total_products = $cartItems->count();
                $total_items = $cartItems->sum('qty');
                $order = new Order();
                $order->user_id = $userId ?? null;
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->address = $request->address;
                $order->city = $request->city;
                $order->phone = $request->phone;
                $order->postal_code = $request->postal_code ?? null;
                $order->landmark = $request->landmark ?? null;
                $order->subtotal = $subtotal;
                $order->shipping = $shipping;
                $order->total = $total;
                $order->status = 'Pending';
                $order->total_products = $total_products;
                $order->total_items = $total_items;
                $order->save();
                if ($request->save_for_later == 'on' && Auth::check()) {
                    $address = new Address();
                    $address->user_id = Auth::id();
                    $address->first_name = $request->first_name;
                    $address->last_name = $request->last_name;
                    $address->address = $request->address;
                    $address->city = $request->city;
                    $address->phone = $request->phone;
                    $address->postal_code = $request->postal_code ?? null;
                    $address->landmark = $request->landmark ?? null;
                    $address->save();
                }

                foreach ($cartItems as $item) {
                    DB::table('order_items')->insert([
                        'order_id'    => $order->id,
                        'product_id'  => $item->product_id,
                        'qty'         => $item->qty,
                        'name'        => $item->name,
                        'price'       => $item->price,
                        'total'       => $item->price * $item->qty,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
                DB::table('cart_items')->where('cart_id', $cart->id)->delete();
                DB::table('carts')->where('id', $cart->id)->delete();
                return redirect()->route('welcome')->with('success', 'Order placed successfully!');
            } else {



                $request->validate([
                    'selected_address' => [
                        'required',
                    ]
                ]);
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
                    return redirect()->back()->with('error', 'Your cart is empty.');
                }
                $cartItems = DB::table('cart_items')
                    ->join('products', 'cart_items.product_id', '=', 'products.id')
                    ->select(
                        'cart_items.qty as qty',
                        'products.id as product_id',
                        'products.price as price',
                        'products.name as name'
                    )
                    ->where('cart_items.cart_id', $cart->id)
                    ->get();
                if ($cartItems->isEmpty()) {
                    return redirect()->back()->with('error', 'Your cart is empty.');
                }
                $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
                $shipping = $subtotal >= 2000 ? 0 : 260;
                $total = $subtotal + $shipping;
                $total_products = $cartItems->count();
                $total_items = $cartItems->sum('qty');
                $order = new Order();
                $order->user_id = $userId ?? null;
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->address = $request->address;
                $order->city = $request->city;
                $order->phone = $request->phone;
                $order->postal_code = $request->postal_code ?? null;
                $order->landmark = $request->landmark ?? null;
                $order->subtotal = $subtotal;
                $order->shipping = $shipping;
                $order->total = $total;
                $order->status = 'Pending';
                $order->total_products = $total_products;
                $order->total_items = $total_items;
                $order->save();
                if ($request->save_for_later == 'on' && Auth::check()) {
                    $address = new Address();
                    $address->user_id = Auth::id();
                    $address->first_name = $request->first_name;
                    $address->last_name = $request->last_name;
                    $address->address = $request->address;
                    $address->city = $request->city;
                    $address->phone = $request->phone;
                    $address->postal_code = $request->postal_code ?? null;
                    $address->landmark = $request->landmark ?? null;
                    $address->save();
                }

                foreach ($cartItems as $item) {
                    DB::table('order_items')->insert([
                        'order_id'    => $order->id,
                        'product_id'  => $item->product_id,
                        'qty'         => $item->qty,
                        'name'        => $item->name,
                        'price'       => $item->price,
                        'total'       => $item->price * $item->qty,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
                DB::table('cart_items')->where('cart_id', $cart->id)->delete();
                DB::table('carts')->where('id', $cart->id)->delete();
                return redirect()->route('welcome')->with('success', 'Order placed successfully!');
            }
        } else {
            $request->validate([
                'first_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[A-Za-z\s]+$/',
                ],
                'last_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[A-Za-z\s]+$/',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:500',
                ],
                'city' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[A-Za-z\s]+$/',
                ],
                'phone' => [
                    'required',
                    'regex:/^03[0-9]{2}-[0-9]{7}$/',
                ],
                'postal_code' => [
                    'nullable',
                    'regex:/^[0-9]{5}$/',
                ],
                'landmark' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
            ], [
                'first_name.regex' => 'First name can only contain letters and spaces.',
                'last_name.regex' => 'Last name can only contain letters and spaces.',
                'city.regex' => 'City name can only contain letters and spaces.',
                'phone.regex' => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
                'postal_code.regex' => 'Postal code must be a 5-digit number.',
            ]);


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
                return redirect()->back()->with('error', 'Your cart is empty.');
            }
            $cartItems = DB::table('cart_items')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->select(
                    'cart_items.qty as qty',
                    'products.id as product_id',
                    'products.price as price',
                    'products.name as name'
                )
                ->where('cart_items.cart_id', $cart->id)
                ->get();
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty.');
            }
            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
            $shipping = $subtotal >= 2000 ? 0 : 260;
            $total = $subtotal + $shipping;
            $total_products = $cartItems->count();
            $total_items = $cartItems->sum('qty');
            $order = new Order();
            $order->user_id = $userId ?? null;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->postal_code = $request->postal_code ?? null;
            $order->landmark = $request->landmark ?? null;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->total = $total;
            $order->status = 'Pending';
            $order->total_products = $total_products;
            $order->total_items = $total_items;
            $order->save();
            if ($request->save_for_later == 'on' && Auth::check()) {
                $address = new Address();
                $address->user_id = Auth::id();
                $address->first_name = $request->first_name;
                $address->last_name = $request->last_name;
                $address->address = $request->address;
                $address->city = $request->city;
                $address->phone = $request->phone;
                $address->postal_code = $request->postal_code ?? null;
                $address->landmark = $request->landmark ?? null;
                $address->save();
            }

            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id'    => $order->id,
                    'product_id'  => $item->product_id,
                    'qty'         => $item->qty,
                    'name'        => $item->name,
                    'price'       => $item->price,
                    'total'       => $item->price * $item->qty,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
            DB::table('cart_items')->where('cart_id', $cart->id)->delete();
            DB::table('carts')->where('id', $cart->id)->delete();
            return redirect()->route('welcome')->with('success', 'Order placed successfully!');
        }
    }


    public function trackmyorder()
    {
        return view('orders.trackmyorder');
    }
}
