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
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle after successful login.
     */
    protected function authenticated(Request $request, $user)
    {
        $guestId = $request->cookie('guest_id');

        // Merge guest cart into user's cart
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

            // Merge guest wishlist
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

        // Store user ID in a cookie (for session-expire handling)
        cookie()->queue(cookie('user_id_before_expire', $user->id, 60 * 24 * 30)); // 30 days

        return redirect()->route('welcome')->with('success', 'Successfully Logged In.');
    }

    /**
     * Manual logout handler.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->transferUserDataToGuest($request, $user->id);
        }

        // Clear auth and session
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Remove stored user_id cookie
        cookie()->queue(cookie('user_id_before_expire', '', -1));

        return redirect()->route('welcome')->with('success', 'Successfully Logged Out.');
    }

    /**
     * Shared function for cart/wishlist transfer.
     */
    private function transferUserDataToGuest(Request $request, $userId)
    {
        $guestId = $request->cookie('guest_id');
        if (!$guestId) {
            $guestId = (string) Str::uuid();
            cookie()->queue(cookie('guest_id', $guestId, 60 * 24 * 30)); // 30 days
        }

        // Transfer cart
        DB::table('carts')
            ->where('user_id', $userId)
            ->update([
                'user_id' => null,
                'guest_id' => $guestId,
                'updated_at' => now(),
            ]);

        // Transfer wishlist
        DB::table('wishlists')
            ->where('user_id', $userId)
            ->update([
                'user_id' => null,
                'guest_id' => $guestId,
                'updated_at' => now(),
            ]);
    }
}
