<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id','url'];

    /**
     * Parent category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Recursive relationship (optional helper)
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Products under this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
