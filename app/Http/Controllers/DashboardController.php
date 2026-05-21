<?php 
public function index()
{
    // Add ->with('items') right before your get() or paginate()
    $orders = Order::with('items')->latest()->take(10)->get();

    return view('admin.dashboard', [
        'orders' => $orders,
        'totalSales' => $totalSales, // your existing data
        'pendingCount' => $pendingCount,
        'completedCount' => $completedCount,
    ]);
}