<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = \App\Models\Cart::with(['items.product'])
            ->firstOrCreate(['user_id' => \Illuminate\Support\Facades\Auth::id()]);

        return view('cart.index', compact('cart'));
    }


    public function update(Request $request, $cart_id, $product_id)
    {
        $quantity = max(1, (int) $request->input('quantity'));

        $updated = \App\Models\CartItem::where('cart_id', $cart_id)
            ->where('product_id', $product_id)
            ->update(['quantity' => $quantity]);

        if (!$updated) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return response()->json(['success' => true, 'quantity' => $quantity]);
    }


   public function remove($cart_id, $product_id)
    {
        $deleted = \App\Models\CartItem::where('cart_id', $cart_id)
            ->where('product_id', $product_id)
            ->delete();

        if (!$deleted) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return response()->json(['success' => true]);
    }



}
