<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'Completed')->sum('total_price');

        $pendingCount = Order::where('status', 'Pending')->count();

        $completedCount = Order::where('status', 'Completed')->count();

        $orders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'pendingCount',
            'completedCount',
            'orders'
        ));
    }
}