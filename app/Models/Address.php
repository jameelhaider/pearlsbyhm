<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
     protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'city',
        'phone',
        'postal_code',
        'landmark',
    ];
}
