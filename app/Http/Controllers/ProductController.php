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
    /**
 * Show the form for creating a new product.
 */
public function create()
{
    // 1. Fetch all available categories from your database
    $categories = \App\Models\Category::all();

    // 2. Pass them directly down to your product creation form layout
    // (Change 'admin.products.create' to match your actual view folder path if different)
    return view('admin.products.create', compact('categories'));
}

public function store(Request $request)
{
    // 🚀 Ensure category_id is validated and received from your form dropdown selection
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required|integer', // 👈 Captures the numerical choice option
    ]);

    // Save the new product details into the database
    \App\Models\Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'category_id' => $request->category_id, // 👈 Saves the chosen category relation ID
        'stock' => $request->has('stock') ? 1 : 0,
    ]);

    return redirect()->back()->with('success', 'Product updated successfully!');
}
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min=0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Handle Image Upload if a fresh file was chosen
    if ($request->hasFile('image')) {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->image_path = $request->file('image')->store('products', 'public');
    }

    // Save changes
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->save();

    return redirect()->back()->with('success', 'Product updated successfully!');
}

/**
 * Emergency Fallback: If the application forces a redirect,
 * safely pass data back to the view workspace instead of crashing.
 */
public function edit($id)
{
    $product = \App\Models\Product::findOrFail($id);
    $products = \App\Models\Product::with('category')->get();
    $categories = \App\Models\Category::all();

    // This redirects back to your main panel layout but passes the item safely
    return view('admin.products', compact('product', 'products', 'categories'))
        ->with('triggerModalId', $id);
}
}
