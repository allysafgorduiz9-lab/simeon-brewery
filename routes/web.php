<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Admin\OrderController; 
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

// ========================
// CUSTOMER ROUTES
// ========================
Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::get('/menu', [FrontEndController::class, 'menu'])->name('menu');
Route::post('/add-cart', [FrontEndController::class, 'addToCart'])->name('addCart');
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::post('/checkout', [FrontEndController::class, 'placeOrder'])->name('placeOrder');

// ========================
// ADMIN ROUTES
// ========================

// Login
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');

// Dashboard route (Handles displaying the sales data)
Route::get('/admin/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');

// Automatic redirect if you just type /admin
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

// Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Toggle Store Status

use App\Models\Setting;

Route::post('/admin/store-toggle', function () {

    $setting = Setting::first();

    if (!$setting) {
        $setting = new Setting();
        $setting->store_status = 'open';
    } else {
        $setting->store_status = $setting->store_status === 'open' ? 'closed' : 'open';
    }

    $setting->save();

    return back();
});

// Orders



Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::post('/admin/order/update/{id}', [AdminController::class, 'updateOrder'])->name('admin.order.update');

// Products
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');

// Your other routes:
//Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::patch('/admin/products/{id}/update-status', [ProductController::class, 'updateStatus'])->name('admin.products.update-status');
// Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');


// Categories
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::post('/admin/category/add', [AdminController::class, 'addCategory'])->name('admin.category.add');
Route::post('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

// Reports
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

// Feedbacks
Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('admin.feedbacks');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('removeCart');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/setup-test-order', function () {
    // Create a dummy order
    $order = Order::create([
        'customer_name' => 'Juan Dela Cruz',
        'phone' => '09123456789',
        'order_type' => 'pickup',
        'method' => 'GCash',
        'total_price' => 270.00,
        'status' => 'Pending'
    ]);

    // Attach items to that order
    OrderItem::create([
        'order_id' => $order->id,
        'product_name' => 'Iced Spanish Latte',
        'quantity' => 1,
        'price' => 140.00
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_name' => 'Dark Mocha Frappe',
        'quantity' => 1,
        'price' => 130.00
    ]);

    return "Test coffee order created successfully! Go check your dashboard.";
});

Route::get('/order-confirmation', function() {
    return view('customer.receipt', [
        'receiptId' => request('receiptId'),
        'name' => request('name'),
        'total' => request('total'),
        'method' => request('method')
    ]);
})->name('order.confirmation');
Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

Route::patch('/admin/products/{id}/update-status', [ProductController::class, 'updateStatus'])->name('admin.products.update-status');
Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

Route::post('/admin/toggle-store', [\App\Http\Controllers\AdminController::class, 'toggleStoreStatus'])->name('admin.toggleStore');


// Ensure your route is defined exactly like this:
Route::post('/admin/product/add', [ProductController::class, 'store'])->name('admin.product.add');

// Also, make sure your delete and toggle routes are named correctly to avoid more errors:
Route::post('/admin/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');
Route::post('/admin/product/toggle/{id}', [ProductController::class, 'toggle'])->name('admin.product.toggle');
Route::post('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');

Route::post('/admin/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('admin.product.update');
// Use 'PUT' or 'PATCH' for updates

Route::put('/admin/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])
     ->name('admin.products.update');


     Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirects to home after logout
})->name('logout');

Route::get('/admin/check-new-orders', [\App\Http\Controllers\AdminController::class, 'checkNewOrders']);