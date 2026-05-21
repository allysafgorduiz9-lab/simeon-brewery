
<?php 

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate Total Sales (Sum of total_price from completed orders)
        $totalSales = Order::where('status', 'Completed')->sum('total_price');

        // 2. Count Pending Orders
        $pendingCount = Order::where('status', 'Pending')->count();

        // 3. Count Completed Orders
        $completedCount = Order::where('status', 'Completed')->count();

        // 4. Fetch the 10 most recent orders *WITH* their items to prevent that type error!
        // (Eager loading with('items') solves the exact crash you saw)
        $orders = Order::with('items')->latest()->take(10)->get();

        // 5. Pass all variables smoothly to your dashboard blade view
        return view('admin.dashboard', compact(
            'totalSales', 
            'pendingCount', 
            'completedCount', 
            'orders'
        ));
    }
}