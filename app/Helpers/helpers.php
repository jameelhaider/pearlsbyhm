<?php

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


if (!function_exists('getOrCreateGuestId')) {
    function getOrCreateGuestId()
    {
        if (!request()->cookie('guest_id')) {
            $guestId = (string) Str::uuid();
            cookie()->queue(cookie('guest_id', $guestId, 60 * 24 * 30));
            return $guestId;
        }
        return request()->cookie('guest_id');
    }
}


if (!function_exists('getCartItemCount')) {
    function getCartItemCount()
    {
        if (Auth::check()) {
            $cart = DB::table('carts')->where('user_id', Auth::id())->first();
        } else {
            $guestId = getOrCreateGuestId();
            $cart = DB::table('carts')->where('guest_id', $guestId)->first();
        }

        if ($cart) {
            return CartItem::where('cart_id', $cart->id)->sum('qty');
        }
        return 0;
    }
}
