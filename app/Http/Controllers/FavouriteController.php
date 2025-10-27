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

    public function store(Product $product): RedirectResponse
    {
        $userId = auth()->id();

        abort_unless($userId, 403);

        $alreadyFavorited = Favourite::where('user_id', $userId)
            ->where('product_id', $product->getKey())
            ->exists();

        if ($alreadyFavorited) {
            return redirect()
                ->route('favorites.show', $product)
                ->with('status', "{$product->name} is already in your favorites.");
        }

        Favourite::create([
            'user_id' => $userId,
            'product_id' => $product->getKey(),
        ]);

        return redirect()
            ->route('favorites.show', $product)
            ->with('status', "{$product->name} has been added to your favorites.");
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
            'isFavorited' => true,
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
