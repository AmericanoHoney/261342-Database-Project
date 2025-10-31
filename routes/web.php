<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Public Routes (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/detail/{product}', [ProductController::class, 'show'])->name('detail');

// สมัครสมาชิก (Guest เท่านั้น)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes (ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update/{cart_id}/{product_id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart_id}/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Checkout + Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Favorites
    Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites');
    Route::get('/favorites/{product}', [FavouriteController::class, 'show'])->name('favorites.show');
    Route::post('/favorites/{product}', [FavouriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavouriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favourites/toggle/{product:product_id}', [FavouriteController::class, 'toggle'])->name('favourites.toggle');
});

require __DIR__.'/auth.php';
