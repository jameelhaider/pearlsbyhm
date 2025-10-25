<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'site_name',
        'site_description',
        'site_logo',
        'site_description',
        'shipping_charges',
        'shipping_free_on',
    ];
}
