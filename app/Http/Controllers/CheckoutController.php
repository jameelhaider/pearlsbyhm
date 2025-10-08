<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'address'      => 'required|string',
            'city'         => 'required|string|max:255',
            'phone'        => 'required|string|max:50',
            'postal_code'  => 'nullable|string|max:50',
            'landmark'     => 'nullable|string|max:255',
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
        $order->total_products = $total_products;
        $order->total_items = $total_items;
        $order->save();
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
