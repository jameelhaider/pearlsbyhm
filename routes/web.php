<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WishlistController;
use App\Models\Category;
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

            Route::get('/delete/image/{id}', [ProductsController::class, 'deleteimage'])->name("product.deleteimage");
        });


         Route::group(['prefix' => 'categories'], function () {
            Route::post('/submit', [CategoryController::class, 'submit'])->name("category.submit");
            Route::get('/create', [CategoryController::class, 'create'])->name("category.create");
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name("category.edit");
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name("category.delete");
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name("category.update");
            Route::get('/', [CategoryController::class, 'index'])->name("category.index");
        });

    });
});




Route::get('/', function () {
    $products = DB::table('products')
        ->get();
    return view('welcome', compact('products','categories'));
})->name('welcome');

Route::get('/product/details/{id}', [ProductsController::class, 'productdetails'])->name('prduct.details');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/track-my-order', [CheckoutController::class, 'trackmyorder'])->name('track.order');



Route::middleware(['auth'])->prefix('accounts')->group(function () {
    Route::get('/', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('/my-orders', [AccountsController::class, 'myorders'])->name('myorders.index');
    Route::get('/addresses', [AccountsController::class, 'myaddresses'])->name('address.index');
    Route::get('/addresses/create', [AccountsController::class, 'createaddress'])->name('address.create');
    Route::get('/addresses/edit/{id}', [AccountsController::class, 'editaddress'])->name('address.edit');

    Route::post('/addresses/save', [AccountsController::class, 'saveaddress'])->name('address.save');
    Route::post('/addresses/update/{id}', [AccountsController::class, 'updateaddress'])->name('address.update');
    Route::post('/addresses/delete/{id}', [AccountsController::class, 'deleteaddress'])->name('address.delete');


    Route::get('/change-password', [AccountsController::class, 'changepassword'])->name('change.password');
    Route::post('/change-password/save', [AccountsController::class, 'changepasswordsave'])->name('change.password.save');
});


Auth::routes();
