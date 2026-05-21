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
        // 1. Validate the form entries to make sure fields are filled correctly
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required', // can be string or integer depending on your setup
            'price' => 'required|numeric|min:0',
            'stock' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB file size safety limit
        ]);

        // 2. Instantiate a brand new empty database record row
        $product = new Product();
        $product->name = $validated['name'];
        
        // Match up your column names here (e.g., if your column is named 'category')
        $product->category = $validated['category_id']; 
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];

        // 3. Handle the image file upload logic securely
        if ($request->hasFile('image')) {
            // This safely stores the image file onto your local disk at: storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
            
            // This saves the clean text path link string (e.g., "products/filename.jpg") into your database!
            $product->image = $imagePath;
        }

        // 4. Fire the SQL command to save everything permanently to your database
        $product->save();

        // 5. Send the admin back to your premium manage menu table with a quick success flash badge
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }
}
