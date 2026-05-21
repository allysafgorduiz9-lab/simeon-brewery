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
    // 1. Get all recent orders for the Audit Log
    $recentOrders = Order::orderBy('created_at', 'desc')->take(10)->get();

    // 2. Get Sales grouped by Date for the Graph
    // This ensures May 22nd is captured based on the exact timestamp
    $salesData = Order::selectRaw('DATE(created_at) as order_date, SUM(total_price) as daily_total')
        ->groupBy('order_date')
        ->orderBy('order_date', 'ASC')
        ->get();

    $weeklyLabels = $salesData->pluck('order_date');
    $weeklySalesValues = $salesData->pluck('daily_total');

    return view('admin.analytics', compact('recentOrders', 'weeklyLabels', 'weeklySalesValues', ...));
}
}