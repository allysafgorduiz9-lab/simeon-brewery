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
        // 1. Calculate genuine metric numbers from your existing database tables
        // (Using fallbacks if your checkout tables aren't fully migrated yet)
        $totalSales = DB::table('orders')->where('status', 'completed')->sum('total_price') ?? 0.00;
        $totalOrders = DB::table('orders')->count() ?? 0;
        $avgOrderValue = $totalOrders > 0 ? ($totalSales / $totalOrders) : 0.00;
        
        // Count how many products are registered across the entire system
        $activeProductsCount = \App\Models\Product::count();

        // 2. Fetch the real product count grouped by each category name for the charts
        $categoryData = \App\Models\Category::withCount('products')->get();
        
        // Split them into clean arrays for JavaScript to read easily
        $chartLabels = $categoryData->pluck('name')->toArray();         // e.g., ["Coffee-Based", "Non-Coffee"]
        $chartCounts = $categoryData->pluck('products_count')->toArray(); // e.g., [3, 1]

        // 3. Pass all live variables into the admin view file
        return view('admin.reports', compact(
            'totalSales', 
            'totalOrders', 
            'avgOrderValue', 
            'activeProductsCount',
            'chartLabels',
            'chartCounts'
        ));
    }
}