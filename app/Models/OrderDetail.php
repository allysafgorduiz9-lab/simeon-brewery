<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    // If your database table is named something else like 'order_items', uncomment the line below:
    // protected $table = 'order_items';

    protected $fillable = ['order_id', 'product_name', 'quantity', 'price'];
}