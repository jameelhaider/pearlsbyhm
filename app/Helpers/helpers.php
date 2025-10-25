<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Slide;
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


if (!function_exists('getCategories')) {
    function getCategories()
    {
        return \App\Models\Category::with('children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }
}

if (!function_exists('getslides')) {
    function getslides()
    {
        return Slide::get();
    }
}

if (!function_exists('shipping_charges')) {
    function shipping_charges()
    {
        return DB::table('settings')->where('id','1')->first()->shipping_charges;
    }
}

if (!function_exists('shipping_free_on')) {
    function shipping_free_on()
    {
       return DB::table('settings')->where('id','1')->first()->shipping_free_on;
    }
}

if (!function_exists('site_description')) {
    function site_description()
    {
       return DB::table('settings')->where('id','1')->first()->site_description;
    }
}

if (!function_exists('site_name')) {
    function site_name()
    {
       return DB::table('settings')->where('id','1')->first()->site_name;
    }
}

if (!function_exists('site_logo')) {
    function site_logo()
    {
       return DB::table('settings')->where('id','1')->first()->site_logo;
    }
}
