<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show the Admin Categories Dashboard
     */
    public function categories()
    {
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

    /**
     * Management Analytics & Reports
     */
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
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now($timezone)->subDays($i)->format('M d');
            $chartData[$date] = 0;
        }

        foreach ($orders as $order) {
            $date = \Carbon\Carbon::parse($order->created_at, $timezone)->format('M d');
            if (array_key_exists($date, $chartData)) {
                $chartData[$date] += $order->total_price;
            }
        }

        $weeklyLabels = array_keys($chartData);
        $weeklySalesValues = array_values($chartData);

        // 4. NEW: Calculate the most popular product
        $mostBoughtProduct = \App\Models\OrderItem::select('product_name', \DB::raw('COUNT(*) as count'))
            ->groupBy('product_name')
            ->orderBy('count', 'desc')
            ->first();

        // Stats
        $totalSales = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        $activeProductsCount = \App\Models\Product::where('stock', '>', 0)->count();

        return view('admin.reports', compact(
            'recentOrders', 'weeklyLabels', 'weeklySalesValues', 
            'totalSales', 'totalOrders', 'avgOrderValue', 
            'activeProductsCount', 'mostBoughtProduct'
        ));
    }

    /**
     * Toggle the manual store open/closed status
     */
    public function toggleStoreStatus(Request $request)
    {
        $setting = DB::table('store_settings')->where('key', 'store_status')->first();

        $newStatus = ($setting->value === 'open') ? 'closed' : 'open';

        DB::table('store_settings')
            ->where('key', 'store_status')
            ->update(['value' => $newStatus, 'updated_at' => now()]);

        return back()->with('success', "Store status manually changed to " . strtoupper($newStatus) . "!");
    }

    public function checkNewOrders() 
{
    $count = \App\Models\Order::count();
    return response()->json(['count' => $count]);
}
}