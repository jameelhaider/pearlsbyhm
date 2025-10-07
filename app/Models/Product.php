<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'id',
        'name',
        'image',
        'hover_image',
        'price',
        'actual_price',
        'description',
    ];
}
