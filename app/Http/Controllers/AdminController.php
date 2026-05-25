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
    // Set to Philippine Time
    $timezone = 'Asia/Manila';

    // 1. Get all orders from the last 7 days
    $orders = \App\Models\Order::where('created_at', '>=', \Carbon\Carbon::now($timezone)->subDays(6)->startOfDay())
                ->orderBy('created_at', 'DESC')
                ->get();

    // 2. Prepare Data for Table (Audit Log)
    $recentOrders = $orders->take(10); 

    // 3. Prepare Data for Chart
    // Create an array of the last 7 days (formatted as M d)
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now($timezone)->subDays($i)->format('M d');
        $chartData[$date] = 0; // Initialize with 0
    }

    // Loop through the orders and add them to their respective dates
    foreach ($orders as $order) {
        $date = \Carbon\Carbon::parse($order->created_at, $timezone)->format('M d');
        if (array_key_exists($date, $chartData)) {
            $chartData[$date] += $order->total_price;
        }
    }

    $weeklyLabels = array_keys($chartData);
    $weeklySalesValues = array_values($chartData);

    // Stats
    $totalSales = $orders->sum('total_price');
    $totalOrders = $orders->count();
    $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
    $activeProductsCount = \App\Models\Product::where('stock', '>', 0)->count();

    return view('admin.reports', compact(
        'recentOrders', 'weeklyLabels', 'weeklySalesValues', 
        'totalSales', 'totalOrders', 'avgOrderValue', 'activeProductsCount'
    ));
}
    /**
 * Toggle the manual store open/closed status
 */
public function toggleStoreStatus(Request $request)
{
    // Find the setting record
    $setting = DB::table('store_settings')->where('key', 'store_status')->first();

    // Flip the status string back and forth
    $newStatus = ($setting->value === 'open') ? 'closed' : 'open';

    // Update the database
    DB::table('store_settings')
        ->where('key', 'store_status')
        ->update(['value' => $newStatus, 'updated_at' => now()]);

    return back()->with('success', "Store status manually changed to " . strtoupper($newStatus) . "!");
}


}