<?php

namespace App\Http\Controllers;

use App\Models\Product; // 👈 Make sure your Product model is imported here!
use Illuminate\Http\Request;
use App\Models\Category;

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
    // Use ->with('category') to load the data efficiently
    $products = Product::with('category')->get(); 
    $categories = Category::all(); 
    
    return view('admin.products.index', compact('products', 'categories'));
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
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Create the product
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price; 
    $product->category_id = $request->category_id;
   // $product->is_available = 1;

    // Handle Image Upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path; // Saves 'products/filename.jpg'
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validate the request to ensure category_id is present
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id', // Important: Ensures it's not null
    ]);
    
    // Assign the values from the request
    $product->name = $request->name;
    $product->price = $request->price;
    $product->category_id = $request->category_id; // <--- Make sure this line exists!
    
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }
    
    $product->save();
    
    return redirect()->back()->with('success', 'Product updated successfully!');
}
/*
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

public function destroy($id)
{
    // 1. Find the product
    $product = Product::findOrFail($id);
    
    // 2. Optional: Delete the associated image file from storage
    if ($product->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
    }
    
    // 3. Delete the product from the database
    $product->delete();
    
    // 4. Redirect back with a success message
    return redirect()->back()->with('success', 'Product deleted successfully!');
}
}
