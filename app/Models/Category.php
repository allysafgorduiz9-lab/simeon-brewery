<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * A category has many products
     */
    public function products(): HasMany
    {
        // 🛠️ The second argument tells Laravel exactly which column connects them!
        return $this->hasMany(Product::class, 'category_id');
    }
}