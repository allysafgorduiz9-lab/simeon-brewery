<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Make sure Order is imported
use App\Models\Product;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;

// CHANGE THIS LINE FROM AdminController TO DashboardController:
class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate Total Sales (Sum of total_price from completed orders)
        $totalSales = Order::where('status', 'Completed')->sum('total_price');

        // 2. Count Pending Orders
        $pendingCount = Order::where('status', 'Pending')->count();

        // 3. Count Completed Orders
        $completedCount = Order::where('status', 'Completed')->count();

        // 4. Fetch the 10 most recent orders WITH their items
        $orders = Order::with('items')->latest()->take(10)->get();

        // 5. Pass variables smoothly to your dashboard blade view
        return view('admin.dashboard', compact(
            'totalSales', 
            'pendingCount', 
            'completedCount', 
            'orders'
        ));
    }
}