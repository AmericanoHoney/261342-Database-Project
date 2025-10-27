<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavouriteController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        $favorites = Favourite::with(['product.category'])
            ->where('user_id', $userId)
            ->get();

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }

    public function toggle(Request $request, Product $product): JsonResponse
    {
        $user = $request->user();
        abort_unless($user, 401);

        // ใช้ belongsToMany บน User เพื่อ toggle รายการโปรด
        $toggled = $user->favourites()->toggle($product->getKey());

        return response()->json([
            'liked' => !empty($toggled['attached']),
        ]);
    }

    public function store(Product $product): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $alreadyFavorited = Favourite::where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->exists();

        if ($alreadyFavorited) {
            return redirect()
                ->route('favorites.show', $product)
                ->with('status', "{$product->name} is already in your favorites.");
        }

        Favourite::create([
            'user_id' => $user->getKey(),
            'product_id' => $product->getKey(),
        ]);

        return redirect()
            ->route('favorites.show', $product)
            ->with('status', "{$product->name} has been added to your favorites.");
    }

    public function show(Product $product): View
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $isFavorited = Favourite::where('user_id', $user->getKey())
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
        $user = Auth::user();
        abort_unless($user, 403);

        $deleted = Favourite::where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->delete();

        abort_unless($deleted, 404);

        return redirect()
            ->route('favorites')
            ->with('status', "{$product->name} has been removed from your favorites.");
    }
}
