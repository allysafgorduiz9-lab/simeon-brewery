<?php

namespace App\Http\Controllers;

use App\Models\Product; // 👈 Make sure your Product model is imported here!
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function updateStatus(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    // Set stock value to 1 (Available) or 0 (Unavailable) based on selection
    $product->stock = $request->input('status') == '1' ? 1 : 0;
    $product->save();

    return redirect()->back()->with('success', 'Product status updated successfully!');
}

  
    public function index()
    {
        // 1. Fetch all products from your database table
        $products = Product::all(); 

        // 2. Pass the $products variable down to your blade view
        return view('admin.products.index', compact('products'));
    }
}