<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the items for the coffee order.
     */
    public function items()
    {
        // Change this back to OrderItem::class
        return $this->hasMany(OrderItem::class);
    }
}