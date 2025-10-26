<?php

use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/products', fn() => view('products.index'))->name('products');
    Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites');
    Route::get('/favorites/{product}', [FavouriteController::class, 'show'])->name('favorites.show');
    Route::delete('/favorites/{product}', [FavouriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/history', fn() => view('history.index'))->name('history');
    Route::get('/cart', fn() => view('cart.index'))->name('cart');
});

require __DIR__.'/auth.php';
