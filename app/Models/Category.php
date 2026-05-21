<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Allows mass-assignment if you use it later
    protected $fillable = ['name'];

    /**
     * A category has many products
     */
    public function products(): HasMany
    {
        // 🛠️ Links this category directly to your Product model!
        return $this->hasMany(Product::class);
    }
}