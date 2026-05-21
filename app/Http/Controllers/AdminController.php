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
        // 1. Basic Metrics & Category Counts
        $totalSales = DB::table('orders')->where('status', 'completed')->sum('total_price') ?? 0.00;
        $totalOrders = DB::table('orders')->count() ?? 0;
        $avgOrderValue = $totalOrders > 0 ? ($totalSales / $totalOrders) : 0.00;
        $activeProductsCount = \App\Models\Product::count();

        $categoryData = \App\Models\Category::withCount('products')->get();
        $chartLabels = $categoryData->pluck('name')->toArray();
        $chartCounts = $categoryData->pluck('products_count')->toArray();

        // 2. 🗓️ LOCK TIME MATRIX: Fixed Monday to Saturday for the Current Week
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY); // Get Monday of this week
        $endOfWeek = $startOfWeek->copy()->addDays(5)->endOfDay(); // Get Saturday of this week

        // Get sales records grouped by date for this specific week range
        $salesData = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->get();

        $weeklyLabels = [];
        $weeklySalesValues = [];

        // Build the loop array mapping exactly 6 steps from Monday to Saturday
        for ($i = 0; $i < 6; $i++) {
            $currentDay = $startOfWeek->copy()->addDays($i);
            $dateString = $currentDay->format('Y-m-d');
            
            // 🛠️ FORMAT: "Day Name (Month Day)" -> e.g., "Mon (May 18)"
            $weeklyLabels[] = $currentDay->format('D (M d)');
            
            // Find if this date exists in our database query collection
            $matchingRecord = $salesData->firstWhere('date', $dateString);
            $weeklySalesValues[] = $matchingRecord ? (float)$matchingRecord->total : 0.00;
        }

        // 3. Recent Audit Orders
        $recentOrders = DB::table('orders')->orderBy('created_at', 'DESC')->limit(5)->get();

        return view('admin.reports', compact(
            'totalSales', 
            'totalOrders', 
            'avgOrderValue', 
            'activeProductsCount',
            'chartLabels',
            'chartCounts',
            'weeklyLabels',        // 👈 Now holds "Mon (May 18)" to "Sat (May 23)"
            'weeklySalesValues',   // 👈 Now holds corresponding gross numbers
            'recentOrders'
        ));
    }
}