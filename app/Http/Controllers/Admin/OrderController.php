<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // 👈 This belongs outside the class (Imports the Model)
use Illuminate\Http\Request; // 👈 This belongs outside the class (Imports the Request object)

class OrderController extends Controller
{
    /**
     * Display a comprehensive listing of all active and past orders.
     */
    public function index()
    {
        // Fetch ALL orders, paginated by 15 items per page
        $orders = Order::with('items')->latest()->paginate(15);

        // Return your dedicated orders management view
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the status of an order on the fly.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Preparing,Completed'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}