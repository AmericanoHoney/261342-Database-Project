<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class FavouriteController extends Controller
{
    public function index()
    {
        $favorites = Favourite::with(['product.category'])
            ->where('user_id', auth()->id())
            ->get();

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }

    public function show(Product $product)
    {
        $userId = auth()->id();

        $isFavorited = Favourite::where('user_id', $userId)
            ->where('product_id', $product->getKey())
            ->exists();

        abort_unless($isFavorited, 404);

        $product->loadMissing('category');

        return view('detail.index', [
            'product' => $product,
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $userId = auth()->id();

        $deleted = Favourite::where('user_id', $userId)
            ->where('product_id', $product->getKey())
            ->delete();

        abort_unless($deleted, 404);

        return redirect()
            ->route('favorites')
            ->with('status', "{$product->name} has been removed from your favorites.");
    }
}
