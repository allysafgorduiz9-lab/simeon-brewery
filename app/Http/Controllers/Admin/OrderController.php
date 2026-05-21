<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use App\Models\Order;
use Illuminate\Http\Request;

// Inside your OrderController class...
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
    public function index()
    {
        // Fetch ALL orders, paginated by 15 items per page so the list doesn't get too long
        $orders = Order::with('items')->latest()->paginate(15);

        // Return your dedicated orders management view
        return view('admin.orders.index', compact('orders'));
    }
}