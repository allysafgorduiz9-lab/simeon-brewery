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
    // If you have a separate categories table, grab them to show in a dropdown:
    // $categories = Category::all();
    // return view('admin.products.create', compact('categories'));

    return view('admin.products.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required', 
        'price' => 'required|numeric|min:0',
        'stock' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
    ]);

    $product = new Product();
    $product->name = $validated['name'];
    
    // Fixed database column mapping here!
    $product->category_id = $validated['category_id']; 
    
    $product->price = $validated['price'];
    $product->stock = $validated['stock'];

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
}
}
