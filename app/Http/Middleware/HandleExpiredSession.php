<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HandleExpiredSession
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // If user session expired (user logged out automatically)
        if (!Auth::check()) {
            $userId = $request->cookie('user_id_before_expire');

            if ($userId) {
                // Create or use existing guest ID
                $guestId = $request->cookie('guest_id') ?? (string) Str::uuid();
                cookie()->queue(cookie('guest_id', $guestId, 60 * 24 * 30));

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

                // Remove old cookie to prevent re-running
                cookie()->queue(cookie('user_id_before_expire', '', -1));
            }
        }

        return $response;
    }
}
