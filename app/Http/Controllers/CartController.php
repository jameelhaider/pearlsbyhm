<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productId = $request->product_id;
        $quantity = 1;
        $userId = Auth::id();
        $sessionId = Auth::check() ? null : session()->getId();
        $cart = DB::table('carts')
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->first();
        if (!$cart) {
            $cartId = DB::table('carts')->insertGetId([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $cartId = $cart->id;
        }
        $cartItem = DB::table('cart_items')
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            DB::table('cart_items')
                ->where('id', $cartItem->id)
                ->update([
                    'qty' => $cartItem->qty + $quantity,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('cart_items')->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'qty' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return back()->with('success', 'Product added to cart!');
    }


    public function index()
    {
        $cartItems = DB::table('carts')
            ->join('cart_items', 'carts.id', '=', 'cart_items.cart_id')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select(
                'cart_items.id as cart_item_id',
                'products.id as product_id',
                'products.name',
                'products.price',
                'products.image',
                'cart_items.qty'
            )
            ->where(function ($q) {
                $q->where('carts.user_id', auth()->id())
                    ->orWhere('carts.session_id', session()->getId());
            })
            ->get();
        $total = DB::table('carts')
            ->join('cart_items', 'carts.id', '=', 'cart_items.cart_id')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where(function ($q) {
                $q->where('carts.user_id', auth()->id())
                    ->orWhere('carts.session_id', session()->getId());
            })
            ->sum(DB::raw('products.price * cart_items.qty'));
        $itemCount = DB::table('carts')
            ->join('cart_items', 'carts.id', '=', 'cart_items.cart_id')
            ->where(function ($q) {
                $q->where('carts.user_id', auth()->id())
                    ->orWhere('carts.session_id', session()->getId());
            })
            ->count();

        return view('cart.index', [
            'items' => $cartItems,
            'total' => $total,
            'itemCount' => $itemCount,
        ]);
    }

    public function remove($id)
    {
        $item = \App\Models\CartItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
