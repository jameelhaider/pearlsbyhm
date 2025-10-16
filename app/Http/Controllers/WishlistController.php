<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $userId = Auth::id();
        $guestId = getOrCreateGuestId();
        $productId = $request->product_id;
        $wishlistQuery = DB::table('wishlists')
            ->where('product_id', $productId);

        if ($userId) {
            $wishlistQuery->where('user_id', $userId);
        } else {
            $wishlistQuery->where('guest_id', $guestId);
        }
        $exist = $wishlistQuery->first();
        if ($exist) {
            return redirect()->back()->with('error', 'Already added to wishlist');
        }
        DB::table('wishlists')->insert([
            'user_id'    => $userId,
            'guest_id'   => $userId ? null : $guestId,
            'product_id' => $productId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Item added to wishlist');
    }


    public function index()
    {
        $userId = Auth::id();
        $guestId = getOrCreateGuestId();
        $wishlistQuery = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->select(
                'products.image as image',
                'products.hover_image as hover_image',
                'products.name as name',
                'products.url as url',
                'products.price as price',
                'products.actual_price as actual_price',
                'products.id as product_id',
                'wishlists.id as wishlist_id',
            );

        if ($userId) {
            $wishlistQuery->where('wishlists.user_id', $userId);
        } else {
            $wishlistQuery->where('wishlists.guest_id', $guestId);
        }

        $wishlistItems = $wishlistQuery->get();

        return view('wishlist.index', compact('wishlistItems'));
    }
    public function remove($id)
    {
        $wishlist = \App\Models\Wishlist::findOrFail($id);
        $wishlist->delete();
        return back()->with('success', 'Item removed from wishlist.');
    }
}
