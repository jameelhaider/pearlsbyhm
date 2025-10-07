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

        $productId = $request->product_id;
        $exists = DB::table('wishlists')->where('product_id', $productId)
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'This product is already in your wishlist.');
        }
        Wishlist::create([
            'user_id' => Auth::id(),
            'session_id' => Auth::check() ? null : session()->getId(),
            'product_id' => $productId,
        ]);
        return back()->with('success', 'Product added to wishlist!');
    }

    public function index()
    {
        $wishlistItems = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->select(
                'wishlists.id as wishlist_id',
                'products.id as product_id',
                'products.name',
                'products.price',
                'products.actual_price',
                'products.image',
                'products.hover_image',
                'products.description'
            )
            ->where(function ($q) {
                $q->where('wishlists.user_id', auth()->id())
                    ->orWhere('wishlists.session_id', session()->getId());
            })
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }


    public function remove($id)
    {
        $wishlist = \App\Models\Wishlist::findOrFail($id);
        $wishlist->delete();
        return back()->with('success', 'Item removed from wishlist.');
    }
}
