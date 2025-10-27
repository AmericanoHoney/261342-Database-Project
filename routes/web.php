<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavouriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/products', fn() => view('products.index'))->name('products');
    Route::get('/favorites', fn() => view('favorites.index'))->name('favorites');
    Route::get('/history', fn() => view('history.index'))->name('history');
    Route::get('/cart', fn() => view('cart.index'))->name('cart');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/favourites/toggle/{product:product_id}', [FavouriteController::class, 'toggle'])
        ->name('favourites.toggle');
});

require __DIR__.'/auth.php';
