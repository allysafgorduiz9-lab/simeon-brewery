<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Optional fallback if using query builder
use Carbon\Carbon;

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
        // 1. Basic Metrics
        $totalSales = DB::table('orders')->where('status', 'completed')->sum('total_price') ?? 0.00;
        $totalOrders = DB::table('orders')->count() ?? 0;
        $avgOrderValue = $totalOrders > 0 ? ($totalSales / $totalOrders) : 0.00;
        $activeProductsCount = \App\Models\Product::count();

        // 2. Category Breakdown Chart Data (3 Coffee-Based, 1 Non-Coffee)
        $categoryData = \App\Models\Category::withCount('products')->get();
        $chartLabels = $categoryData->pluck('name')->toArray();
        $chartCounts = $categoryData->pluck('products_count')->toArray();

        // 3. 🛠️ REAL SYSTEM DATA: Weekly Gross Tracking (Last 7 Days)
        $salesData = DB::table('orders')
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Map database records into clean coordinates for Chart.js
        $weeklyLabels = [];
        $weeklySalesValues = [];

        // Fill out the last 7 calendar days dynamically so days with 0 sales don't break the chart
        for ($i = 6; $i >= 0; $i--) {
            $dateString = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->format('D'); // e.g., "Mon", "Tue"
            
            $weeklyLabels[] = $dayName;
            
            // Find if this date has matching sales in our database query collection
            $matchingRecord = $salesData->firstWhere('date', $dateString);
            $weeklySalesValues[] = $matchingRecord ? (float)$matchingRecord->total : 0.00;
        }

        // 4. 🛠️ REAL SYSTEM DATA: Recent Orders for Backend System Audit Log
        // (Fetches the 5 most recent orders sequentially from your tables)
        $recentOrders = DB::table('orders')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('admin.reports', compact(
            'totalSales', 
            'totalOrders', 
            'avgOrderValue', 
            'activeProductsCount',
            'chartLabels',
            'chartCounts',
            'weeklyLabels',        // 👈 Passed to chart labels
            'weeklySalesValues',   // 👈 Passed to chart values
            'recentOrders'         // 👈 Passed to audit log table loop
        ));
    }
}