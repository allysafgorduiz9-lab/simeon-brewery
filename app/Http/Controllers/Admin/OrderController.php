<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a comprehensive listing of all active and past orders.
     */
    public function index()
    {
        // Fetch ALL orders, paginated by 15 items per page so the list doesn't get too long
        $orders = Order::with('items')->latest()->paginate(15);

        // Return your dedicated orders management view
        return view('admin.orders.index', compact('orders'));
    }
}