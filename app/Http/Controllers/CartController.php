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
            'qty' => 'required|integer|min:1',
        ]);
        $productId = $request->product_id;
        $qty = (int) $request->qty;
        $userId = Auth::id();
        $guestId = getOrCreateGuestId();
        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
        } else {
            $cart = Cart::firstOrCreate(['guest_id' => $guestId]);
        }
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();
        if ($cartItem) {
            $cartItem->qty += $qty;
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $productId;
            $cartItem->qty = $qty;
            $cartItem->save();
        }
        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }



    public function index()
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
            return view('cart.index', [
                'cartItems' => collect(),
                'total' => 0,
            ]);
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
        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->qty;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }


    public function remove($id)
    {
        $cartItem = DB::table('cart_items')->where('id', $id)->first();
        if (!$cartItem) {
            return back()->with('error', 'Item not found.');
        }
        $cartId = $cartItem->cart_id;
        DB::table('cart_items')->where('id', $id)->delete();
        $remainingItems = DB::table('cart_items')
            ->where('cart_id', $cartId)
            ->count();
        if ($remainingItems === 0) {
            DB::table('carts')->where('id', $cartId)->delete();
        }
        return back()->with('success', 'Item removed from cart.');
    }

    public function updateQty(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);
        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->qty = $request->quantity;
        $cartItem->save();
        return response()->json(['success' => true]);
    }
}
