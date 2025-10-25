<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SlidesController;
use App\Http\Controllers\WishlistController;
use App\Mail\DatabaseBackupMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;











Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/export-database', function () {
        $date = Carbon::now()->format('d_M_y_h_i_A');
        $filename = "Backup_Pearls_By_HM_$date.sql";
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $sql = '';

        foreach ($tableNames as $table) {
            $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return DB::connection()->getPdo()->quote($value);
                }, (array) $row);

                $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    })->name('export.database');

    Route::get('/send-database-backup', function () {
        $date = Carbon::now()->format('d_M_y_h_i_A');
        $filename = "Backup_Pearls_By_HM_$date.sql";
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $sql = '';

        foreach ($tableNames as $table) {
            $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return DB::connection()->getPdo()->quote($value);
                }, (array) $row);

                $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }
        Mail::to(['jameelhaider047@gmail.com', 'pearlsbyhm@gmail.com'])
            ->send(new DatabaseBackupMail($sql, $filename));
        return redirect()->back()->with('success', 'Database backup sent to email successfully.');
    })->name('send.database.backup');


    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [AdminDashboardController::class, 'settingsupdate'])->name('settings.update');

        Route::get('/orders/{status}', [OrdersController::class, 'index'])->name('orders');
        Route::get('/order/{id}/details', [OrdersController::class, 'details'])->name('order.details');
        Route::get('/order/{id}/update/status/{status}', [OrdersController::class, 'updatestatus'])->name('order.status.update');

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

        Route::group(['prefix' => 'faqs'], function () {
            Route::post('/submit', [FaqsController::class, 'submit'])->name("faq.submit");
            Route::get('/create', [FaqsController::class, 'create'])->name("faq.create");
            Route::get('/edit/{id}', [FaqsController::class, 'edit'])->name("faq.edit");
            Route::get('/delete/{id}', [FaqsController::class, 'delete'])->name("faq.delete");
            Route::post('/update/{id}', [FaqsController::class, 'update'])->name("faq.update");
            Route::get('/', [FaqsController::class, 'index'])->name("faq.index");
        });

        Route::group(['prefix' => 'slides'], function () {
            Route::post('/submit', [SlidesController::class, 'submit'])->name("slide.submit");
            Route::get('/create', [SlidesController::class, 'create'])->name("slide.create");
            Route::get('/edit/{id}', [SlidesController::class, 'edit'])->name("slide.edit");
            Route::get('/delete/{id}', [SlidesController::class, 'delete'])->name("slide.delete");
            Route::post('/update/{id}', [SlidesController::class, 'update'])->name("slide.update");
            Route::get('/', [SlidesController::class, 'index'])->name("slide.index");
        });
    });
});




Route::get('/', function () {
    $products = DB::table('products')
        ->latest('created_at')
        ->take(32)
        ->get();

    return view('welcome', compact('products'));
})->name('welcome');


Route::get('/faqs', function () {
    $faqs = DB::table('faqs')
        ->get();
    return view('usefulllinks.faqs', compact('faqs'));
})->name('faqs');

Route::get('/privacy-policy', function () {
    return view('usefulllinks.privacy');
})->name('privacy');

Route::get('/terms-conditions', function () {
    return view('usefulllinks.terms');
})->name('terms');

Route::get('/return-exchange', function () {
    return view('usefulllinks.return');
})->name('return');

Route::get('/shipping-policy', function () {
    return view('usefulllinks.shipping');
})->name('shipping');

Route::get('/order-cancel-policy', function () {
    return view('usefulllinks.cancel');
})->name('cancel');


Route::get('/category/{url}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/allproducts', [ProductsController::class, 'allproducts'])->name('products.all');

Route::get('/product/details/{url}', [ProductsController::class, 'productdetails'])->name('prduct.details');

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


Route::get('/shop-by-category', [CategoryController::class, 'shopbycategory'])->name('shop.category');



Route::middleware(['auth'])->prefix('accounts')->group(function () {
    Route::get('/', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('/my-orders', [AccountsController::class, 'myorders'])->name('myorders.index');
    Route::get('/my-orders/details/{url}', [AccountsController::class, 'myorderdetail'])->name('myorders.details');
    Route::get('/addresses', [AccountsController::class, 'myaddresses'])->name('address.index');
    Route::get('/addresses/create', [AccountsController::class, 'createaddress'])->name('address.create');
    Route::get('/addresses/edit/{url}', [AccountsController::class, 'editaddress'])->name('address.edit');

    Route::post('/addresses/save', [AccountsController::class, 'saveaddress'])->name('address.save');
    Route::post('/addresses/update/{id}', [AccountsController::class, 'updateaddress'])->name('address.update');
    Route::post('/addresses/delete/{id}', [AccountsController::class, 'deleteaddress'])->name('address.delete');


    Route::get('/change-password', [AccountsController::class, 'changepassword'])->name('change.password');
    Route::post('/change-password/save', [AccountsController::class, 'changepasswordsave'])->name('change.password.save');
});


Auth::routes();
