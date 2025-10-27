<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->loadMissing('category');

        $userId = auth()->id();

        $isFavorited = false;

        if ($userId) {
            $isFavorited = Favourite::where('user_id', $userId)
                ->where('product_id', $product->getKey())
                ->exists();
        }

        return view('detail.index', [
            'product' => $product,
            'isFavorited' => $isFavorited,
        ]);
    }
}
