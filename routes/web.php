<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\AdminController;

// Customer Routes
Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::get('/menu', [FrontEndController::class, 'menu'])->name('menu');
Route::post('/add-cart', [FrontEndController::class, 'addToCart'])->name('addCart');
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::post('/checkout', [FrontEndController::class, 'placeOrder'])->name('placeOrder');

// Admin Routes
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admin/home', function() {
    return redirect('/admin');
})->name('admin.home');

Route::post('/admin/toggle-store', [AdminController::class, 'toggleStore'])->name('admin.toggle');

Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::post('/admin/order/update/{id}', [AdminController::class, 'updateOrder'])->name('admin.order.update');

Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
Route::post('/admin/product/add', [AdminController::class, 'addProduct'])->name('admin.product.add');
Route::post('/admin/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
Route::post('/admin/product/toggle/{id}', [AdminController::class, 'toggleProduct'])->name('admin.product.toggle');
Route::post('/admin/product/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');

Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::post('/admin/category/add', [AdminController::class, 'addCategory'])->name('admin.category.add');
Route::post('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('admin.feedbacks');