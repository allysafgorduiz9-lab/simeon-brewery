<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Your other code...

    /**
     * Get the items/products for this specific order.
     */
    public function items()
    {
        // Change 'OrderItem' to whatever your actual order item model is named
        return $this->hasMany(OrderItem::class); 
    }
}