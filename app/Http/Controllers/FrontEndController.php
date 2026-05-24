<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class FrontEndController extends Controller
{
    /**
     * Internal helper to verify if the coffee shop is open.
     */
    private function isStoreOpen() 
    {
        return env('STORE_STATUS', 'open') === 'open';
    }

    /**
     * Frontend Welcome Landing Page.
     */
    public function index()
    {
        $products = \App\Models\Product::where('stock', 1)->get(); 
        return view('welcome', compact('products'));
    }

    /**
     * Display the Customer Menu Page.
     */
   public function menu(Request $request)
{
    // 1. Determine if the store is open
    $rawStatus = \DB::table('settings')->value('store_status') ?? 'open';
    $storeStatus = strtolower(trim($rawStatus));
    $isStoreOpen = ($storeStatus === 'open' || $storeStatus == '1');

    // 2. Start query for products, filtering by stock > 0
    $query = \App\Models\Product::query()->where('stock', '>', 0);

    // 3. If searching, filter by name
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 4. If filtering by category, filter by category_id
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category_id', $request->category);
    }

    $products = $query->get();
    $categories = \App\Models\Category::all();

    // 5. Return view with all necessary variables
    return view('customer.menu', compact('products', 'categories', 'isStoreOpen'));
}
    /**
     * Handle adding items to the customer's cart session.
     */
    public function addToCart(Request $request) 
    {
        // Look for product_id matching the hidden form field value from menu.blade.php
        $productId = $request->input('product_id') ?? $request->input('id');
        $product = \App\Models\Product::findOrFail($productId);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Added to Cart!');
    }

    /**
     * Display the Shopping Cart view.
     */
    public function cart()
{
    // Fetch settings here
   // $gcashNum = \App\Models\Setting::where('key', 'gcash_number')->first();
    //$mayaNum = \App\Models\Setting::where('key', 'paymaya_number')->first();

    // Use the actual column name here (e.g., 'content' or whatever you found)
   // $gcashNumber = $gcashNum ? $gcashNum->your_actual_column_name : 'N/A';
   // $mayaNumber = $mayaNum ? $mayaNum->your_actual_column_name : 'N/A';

    return view('customer.cart');
}

    /**
     * Process checkout forms, populate order tables, and display receipt records.
     */
    public function placeOrder(Request $request) 
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect('/menu')->with('error', 'Your shopping cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }
        
        $order = Order::create([
            'customer_name' => $request->name,
            'phone'         => $request->phone,
            'order_type'    => $request->order_type ?? 'pickup',
            'method'        => $request->method, 
            'total_price'   => $total,
            'status'        => 'Pending',
            'reference_number' => $request->reference_number
        ]);

        foreach ($cart as $cartItem) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_name' => $cartItem['name'],
                'quantity'     => $cartItem['quantity'],
                'price'        => $cartItem['price']
            ]);
        }

        $receiptId = 'ORD-' . $order->id;
        Session::forget('cart');

        return redirect()->route('order.confirmation', [
            'receiptId' => $receiptId,
            'name'      => $order->customer_name,
            'total'     => $order->total_price,
            'method'    => $order->method
        ]);
    }
}