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
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');

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
Route::get('/admin/products', [ProductController::class, 'index']);
Route::post('/admin/product/add', [AdminController::class, 'addProduct'])->name('admin.product.add');
Route::post('/admin/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
Route::post('/admin/product/toggle/{id}', [AdminController::class, 'toggleProduct'])->name('admin.product.toggle');
Route::post('/admin/product/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');

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