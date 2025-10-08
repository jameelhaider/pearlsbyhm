<?php

use Illuminate\Support\Str;

if (!function_exists('getOrCreateGuestId')) {
    function getOrCreateGuestId()
    {
        if (!request()->cookie('guest_id')) {
            $guestId = (string) Str::uuid();
            cookie()->queue(cookie('guest_id', $guestId, 60 * 24 * 30));
            return $guestId;
        }
        return request()->cookie('guest_id');
    }
}
