<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Optional fallback if using query builder

class AdminController extends Controller
{
    /**
     * Show the Admin Categories Dashboard
     */
   /**
     * Show the Admin Categories Dashboard
     */
    public function categories()
{
    // Fetch categories with products correctly using Eloquent relationships
    $categories = \App\Models\Category::with('products')->get();

    return view('admin.categories', compact('categories'));
}
    /**
     * Add a New Category
     */
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 🛠️ THE FIX: Add the full absolute path here too
        \App\Models\Category::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    /**
     * Delete an Existing Category
     */
    public function deleteCategory($id)
    {
        // 🛠️ THE FIX: Add the full absolute path here too
        \App\Models\Category::findOrFail($id)->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    /**
     * Placeholder Login View Method
     */
    public function login()
    {
        return view('admin.login');
    }

    public function reports()
{
    // Sum up completed checkouts
    $totalSales = \DB::table('orders')->where('status', 'completed')->sum('total_price');
    $totalOrders = \DB::table('orders')->count();
    
    // Average order size expression
    $avgOrderValue = $totalOrders > 0 ? ($totalSales / $totalOrders) : 0;
    
    return view('admin.reports', compact('totalSales', 'totalOrders', 'avgOrderValue'));
}
}