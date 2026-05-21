<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController; 
use App\Http\Controllers\ProductController;
use App\Models\Setting;
use App\Models\Order;
use App\Models\OrderItem;

// ========================
// CUSTOMER ROUTES
// ========================
Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::get('/menu', [FrontEndController::class, 'menu'])->name('menu');
Route::post('/add-cart', [FrontEndController::class, 'addToCart'])->name('addCart');
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::post('/checkout', [FrontEndController::class, 'placeOrder'])->name('placeOrder');
Route::get('/order-confirmation', function() {
    return view('customer.receipt', [
        'receiptId' => request('receiptId'),
        'name' => request('name'),
        'total' => request('total'),
        'method' => request('method')
    ]);
})->name('order.confirmation');

// ========================
// ADMIN ROUTES
// ========================

Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

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
Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

// Products
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::post('/admin/product/add', [ProductController::class, 'store'])->name('admin.product.add');
Route::post('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
Route::post('/admin/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');
Route::post('/admin/product/toggle/{id}', [ProductController::class, 'toggle'])->name('admin.product.toggle');
Route::patch('/admin/products/{id}/update-status', [ProductController::class, 'updateStatus'])->name('admin.products.update-status');

// Categories
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::post('/admin/category/add', [AdminController::class, 'addCategory'])->name('admin.category.add');
Route::post('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

// Reports & Feedbacks
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('admin.feedbacks');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('removeCart');

// Utility
Route::get('/setup-test-order', function () {
    $order = Order::create(['customer_name' => 'Juan Dela Cruz', 'phone' => '09123456789', 'order_type' => 'pickup', 'method' => 'GCash', 'total_price' => 270.00, 'status' => 'Pending']);
    OrderItem::create(['order_id' => $order->id, 'product_name' => 'Iced Spanish Latte', 'quantity' => 1, 'price' => 140.00]);
    OrderItem::create(['order_id' => $order->id, 'product_name' => 'Dark Mocha Frappe', 'quantity' => 1, 'price' => 130.00]);
    return "Test coffee order created successfully!";
});