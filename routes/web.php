<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\AdminAccessMiddleware;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

// Authenticated user routes
Route::middleware('auth')->group(function () {
  // Cart routes
  Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
  Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
  Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
  Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

  // Checkout routes
  Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
  Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

  // Order routes
  Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
  Route::post('/profile/update-address', [UserProfileController::class, 'updateInfo'])->name('user.update-info');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', AdminAccessMiddleware::class])->name('admin.')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  // Products
  Route::resource('products', AdminProductController::class);
  // Categories
  Route::resource('categories', CategoryController::class);
  // Orders
  Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
  Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});
