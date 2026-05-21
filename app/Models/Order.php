<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Tells Laravel that an Order has many ordered items connected to it
    public function items()
    {
        // Change OrderItem::class if your pivot or order details model is named differently
        return $this->hasMany(OrderItem::class);
    }
}