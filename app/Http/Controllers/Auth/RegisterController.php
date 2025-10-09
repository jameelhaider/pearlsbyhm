<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle actions after registration.
     */
    protected function registered(Request $request, $user)
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
    }
}
