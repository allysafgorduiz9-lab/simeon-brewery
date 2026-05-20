<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Login Page
   // Login Page
public function login() {
    return view('admin.login');
}

// Login Submit
public function loginSubmit(Request $request) {
    $username = $request->username;
    $password = $request->password;

    if ($username === 'admin' && $password === 'simeon123') {
        // Session to keep user logged in
        session(['admin_logged_in' => true]);
        
        return redirect('/admin/dashboard');
    }
    
    return redirect('/admin')->with('error', 'Invalid credentials');
}

// Dashboard (GET - after login)
public function dashboard(Request $request) {
    // Check if logged in
    if (!session('admin_logged_in')) {
        return redirect('/admin');
    }
    
    try {
        $orders = Order::orderBy('created_at', 'desc')->take(10)->get();
        $totalSales = Order::where('status', 'Completed')->sum('total_price');
        $pendingCount = Order::where('status', 'Pending')->count();
        $completedCount = Order::where('status', 'Completed')->count();
        
        return view('admin.dashboard', compact('orders', 'totalSales', 'pendingCount', 'completedCount'));
    } catch (\Exception $e) {
        return view('admin.dashboard', [
            'orders' => collect([]),
            'totalSales' => 0,
            'pendingCount' => 0,
            'completedCount' => 0
        ]);
    }
}

    // Toggle Store Status
    // Toggle Store
public function toggleStore() {
    $current = env('STORE_STATUS');
    $new = ($current === 'open') ? 'closed' : 'open';
    
    $path = base_path('.env');
    file_put_contents($path, str_replace('STORE_STATUS='.$current, 'STORE_STATUS='.$new, file_get_contents($path)));
    
    return redirect('/admin/dashboard');
}

    // Orders Page
    public function orders() {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    // Update Order Status
    public function updateOrder(Request $request, $id) {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return back();
    }

    // Products Page
    public function products() {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    // Add Product
    // Add Product
// Add Product
public function addProduct(Request $request) {
    $imagePath = null;
    
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        
        if ($file->isValid()) {
            $destinationPath = base_path('public/uploads');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $imageName);
            $imagePath = 'uploads/' . $imageName;
        }
    }
    
    Product::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image_path' => $imagePath,
        'is_available' => true
    ]);
    
    return back();
}

// Update Product
public function updateProduct(Request $request, $id) {
    $product = Product::find($id);
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        
        if ($file->isValid()) {
            $destinationPath = base_path('public/uploads');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $imageName);
            $product->image_path = 'uploads/' . $imageName;
        }
    }
    
    $product->save();
    
    return redirect('/admin/products');
}

    // Toggle Product Availability
    public function toggleProduct($id) {
        $product = Product::find($id);
        $product->is_available = !$product->is_available;
        $product->save();
        return back();
    }

    // Delete Product
    public function deleteProduct($id) {
        $product = Product::find($id);
        
        // Delete image file if exists
        if ($product->image_path) {
            $imagePath = base_path('public/images/' . $product->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $product->delete();
        return back();
    }

   
   

    // Categories Page
    public function categories() {
        $categories = Category::with('products')->get();
        return view('admin.categories', compact('categories'));
    }

    // Add Category
    public function addCategory(Request $request) {
        Category::create(['name' => $request->name]);
        return back();
    }

    // Delete Category
    public function deleteCategory($id) {
        Category::find($id)->delete();
        return back();
    }

    // Reports Page
    public function reports() {
        $orders = Order::where('status', 'Completed')->get();
        $totalSales = $orders->sum('total_price');
        $completedCount = $orders->count();
        
        // Group sales by day (last 7 days)
        $dailySales = [];
        for($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dailySales[$date] = Order::whereDate('created_at', $date)->where('status', 'Completed')->sum('total_price');
        }
        
        return view('admin.reports', compact('orders', 'totalSales', 'completedCount', 'dailySales'));
    }

    // Feedbacks Page
    public function feedbacks() {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }
}