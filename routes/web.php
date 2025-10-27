<?php

use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/detail/{product}', [ProductController::class, 'show'])
    ->name('detail');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/products', fn() => view('products.index'))->name('products');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/{product}', [FavouriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites/{product}', [FavouriteController::class, 'show'])->name('favorites.show');
    Route::delete('/favorites/{product}', [FavouriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/history', fn() => view('history.index'))->name('history');
    Route::get('/cart', fn() => view('cart.index'))->name('cart');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});

require __DIR__.'/auth.php';
