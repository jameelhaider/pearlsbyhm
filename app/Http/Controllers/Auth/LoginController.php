<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $guestId = $request->cookie('guest_id');
        if ($guestId) {
            $guestCart = DB::table('carts')->where('guest_id', $guestId)->first();
            if ($guestCart) {
                $userCart = DB::table('carts')->where('user_id', $user->id)->first();
                if ($userCart) {
                    $guestItems = DB::table('cart_items')->where('cart_id', $guestCart->id)->get();
                    foreach ($guestItems as $item) {
                        $existingItem = DB::table('cart_items')
                            ->where('cart_id', $userCart->id)
                            ->where('product_id', $item->product_id)
                            ->first();

                        if ($existingItem) {
                            DB::table('cart_items')
                                ->where('id', $existingItem->id)
                                ->update([
                                    'qty' => $existingItem->qty + $item->qty,
                                    'updated_at' => now(),
                                ]);
                        } else {
                            DB::table('cart_items')
                                ->where('id', $item->id)
                                ->update([
                                    'cart_id' => $userCart->id,
                                    'updated_at' => now(),
                                ]);
                        }
                    }
                    DB::table('carts')->where('id', $guestCart->id)->delete();
                } else {
                    DB::table('carts')
                        ->where('id', $guestCart->id)
                        ->update([
                            'user_id' => $user->id,
                            'guest_id' => null,
                            'updated_at' => now(),
                        ]);
                }
            }
            $guestWishlistItems = DB::table('wishlists')->where('guest_id', $guestId)->get();

            foreach ($guestWishlistItems as $item) {
                $exists = DB::table('wishlists')
                    ->where('user_id', $user->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($exists) {
                    DB::table('wishlists')->where('id', $item->id)->delete();
                } else {
                    DB::table('wishlists')
                        ->where('id', $item->id)
                        ->update([
                            'user_id' => $user->id,
                            'guest_id' => null,
                            'updated_at' => now(),
                        ]);
                }
            }
        }

        return redirect()->route('welcome')->with('success', 'Successfully Logged In.');
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $guestId = $request->cookie('guest_id');
            if (!$guestId) {
                $guestId = (string) \Illuminate\Support\Str::uuid();
                cookie()->queue(cookie('guest_id', $guestId, 60 * 24 * 30));
            }
            $userCart = DB::table('carts')->where('user_id', $user->id)->first();
            if ($userCart) {
                DB::table('carts')
                    ->where('id', $userCart->id)
                    ->update([
                        'user_id' => null,
                        'guest_id' => $guestId,
                        'updated_at' => now(),
                    ]);
            }
            DB::table('wishlists')
                ->where('user_id', $user->id)
                ->update([
                    'user_id' => null,
                    'guest_id' => $guestId,
                    'updated_at' => now(),
                ]);
        }
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome')->with('success', 'Successfully Logged Out.');
    }
}
