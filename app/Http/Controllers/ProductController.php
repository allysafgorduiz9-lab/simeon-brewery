<?php

namespace App\Http\Controllers;

use App\Models\Product; // 👈 Make sure your Product model is imported here!
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the manage menu / products page.
     */
    public function index()
    {
        // 1. Fetch all products from your database table
        $products = Product::all(); 

        // 2. Pass the $products variable down to your blade view
        return view('admin.products.index', compact('products'));
    }
}