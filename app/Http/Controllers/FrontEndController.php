<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
namespace App\Http\Controllers;

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
        // 🛠️ FIX: If it was using 'status' or 'availability', change it to 'stock'
        // This gets all available products where stock = 1
        $products = Product::where('stock', 1)->get(); 
        
        return view('welcome', compact('products')); // Or whichever view your homepage uses
    }

    /**
     * Display the Customer Menu Page
     */
    public function menu()
    {
        // 🛠️ FIX: Update this query to look for 'stock' as well!
        $products = Product::where('stock', 1)->get();

        return view('menu', compact('products')); // Or customer.menu depending on your folder layout
    }

    /**
     * Handle adding items to the customer's cart session.
     */
    public function addToCart(Request $request) 
    {
        $product = Product::findOrFail($request->id);
        
        if (!$product->is_available) {
            return back()->with('error', 'Item Unavailable');
        }

        $cart = Session::get('cart', []);
        
        // If item already exists in cart, increment quantity instead of rewriting
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

        // Calculate accurate grand total from active session states
        $total = 0;
        foreach ($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }
        
        // 1. Create the main parent Order record matching your MySQL Workbench schema names
        $order = Order::create([
            'customer_name' => $request->name,
            'phone'         => $request->phone,
            'order_type'    => $request->order_type ?? 'pickup',
            'method'        => $request->method, // Matches form naming properties
            'total_price'   => $total,
            'status'        => 'Pending'
        ]);

        // 2. Loop through their active cart items and attach them to the Order
        foreach ($cart as $cartItem) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_name' => $cartItem['name'],
                'quantity'     => $cartItem['quantity'],
                'price'        => $cartItem['price']
            ]);
        }

        // Generate stylized format tag reference text (e.g., ORD-23)
        $receiptId = 'ORD-' . $order->id;

        // 3. Clear customer checkout session data paths
        Session::forget('cart');

        // 4. Redirect them to the route handling your GCash-inspired receipt design
        // Ensure you have a named route inside routes/web.php called 'order.confirmation'
        return redirect()->route('order.confirmation', [
            'receiptId' => $receiptId,
            'name'      => $order->customer_name,
            'total'     => $order->total_price,
            'method'    => $order->method
        ]);
    }
}