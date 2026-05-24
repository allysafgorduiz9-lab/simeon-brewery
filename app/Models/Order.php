<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 👈 ADD THIS FILLABLE ARRAY FOR SECURITY PASSING:
   protected $fillable = [
    'customer_name', 
    'phone', 
    'order_type', 
    'method', 
    'total_price', 
    'status',
    'reference_number', // Add this line here!
];

    /**
     * Get the items for the coffee order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}