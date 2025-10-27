<?php

use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/detail', function () {
    $product = Product::with('category')->first();

    if (! $product) {
        $product = new Product([
            'name' => 'Japan Garden',
            'price' => 60,
            'stock' => 12,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'image_url' => 'images/flowers/ex1.webp',
        ]);

        $product->setRelation('category', new Category(['name' => 'Flower Bouquets']));
    }

    return view('detail.index', [
        'product' => $product,
    ]);
})->name('detail');

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
    Route::get('/favorites/{product}', [FavouriteController::class, 'show'])->name('favorites.show');
    Route::delete('/favorites/{product}', [FavouriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/history', fn() => view('history.index'))->name('history');
    Route::get('/cart', fn() => view('cart.index'))->name('cart');
});

require __DIR__.'/auth.php';
