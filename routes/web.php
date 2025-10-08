<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;







Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


        Route::group(['prefix' => 'products'], function () {
            Route::post('/submit', [ProductsController::class, 'submit'])->name("product.submit");
            Route::get('/create', [ProductsController::class, 'create'])->name("product.create");
            Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name("product.edit");
            Route::get('/delete/{id}', [ProductsController::class, 'delete'])->name("product.delete");
            Route::post('/update/{id}', [ProductsController::class, 'update'])->name("product.update");
            Route::get('/', [ProductsController::class, 'index'])->name("product.index");
        });
    });
});




Route::get('/', function () {
    $products = DB::table('products')
        ->get();
    return view('welcome', compact('products'));
})->name('welcome');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');






Auth::routes();
