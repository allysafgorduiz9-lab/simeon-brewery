<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // Ensure 'image' matches your DB column. Remove 'description' if you don't have that column.
    protected $fillable = ['category_id', 'name', 'price', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}