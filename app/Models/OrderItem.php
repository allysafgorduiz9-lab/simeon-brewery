<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // 👈 ENSURE THIS IS PRESENT HERE AS WELL:
    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}