<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
        'subtotal',
        'shipping',
        'total',
        'status',
        'total_products',
        'total_items',
    ];
}
