<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class FrontEndController extends Controller
{
    private function isStoreOpen() {
        return env('STORE_STATUS', 'open') === 'open';
    }

    public function index() {
        return view('welcome', ['isOpen' => $this->isStoreOpen()]);
    }

    public function menu() {
        $categories = Category::with('products')->get();
        return view('customer.menu', compact('categories'));
    }

    public function addToCart(Request $request) {
        $product = Product::findOrFail($request->id);
        
        if (!$product->is_available) {
            return back()->with('error', 'Item Unavailable');
        }

        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1
        ];
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Added to Cart!');
    }

    public function cart() {
        return view('customer.cart');
    }

    public function placeOrder(Request $request) {
    $cart = Session::get('cart', []);
    if (empty($cart)) return redirect('/menu');

    $total = 0;
    foreach($cart as $item) { 
        $total += $item['price'] * $item['quantity']; 
    }
    
    // Save to Database
    $order = Order::create([
        'customer_name' => $request->name,
        'phone_number' => $request->phone,
        'payment_method' => $request->method,
        'total_price' => $total,
        'status' => 'Pending'
    ]);

    $receiptId = 'ORD-' . $order->id;
    Session::forget('cart');

    return view('customer.receipt', [
        'receiptId' => $receiptId,
        'name' => $request->name,
        'total' => $total,
        'method' => $request->method
    ]);
    }
}