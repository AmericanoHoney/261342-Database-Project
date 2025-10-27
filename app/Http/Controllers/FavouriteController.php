<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = $request->user();

        // ใช้ belongsToMany บน User เพื่อ toggle
        $toggled = $user->favourites()->toggle($product->getKey());

        // ถ้ามีใน 'attached' แปลว่าเพิ่งกด like
        $liked = !empty($toggled['attached']);

        return response()->json([
            'liked' => $liked,
            'product_id' => $product->getKey(),
        ]);
    }
}
