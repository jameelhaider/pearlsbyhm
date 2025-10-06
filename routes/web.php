<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    $products = DB::table('products')
        ->get();
    return view('welcome', compact('products'));
});

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');




Auth::routes();
