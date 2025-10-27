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

        // 🔍 ดึงสินค้ามาเพื่อตรวจสอบ stock
        $product = \App\Models\Product::find($product_id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // ❌ ถ้าจำนวนที่ขอมากกว่าสต็อก
        if ($quantity > $product->stock) {
            return response()->json([
                'error' => 'Not enough stock',
                'available_stock' => $product->stock,
            ], 400);
        }

        // ✅ อัปเดตจำนวนสินค้าในตะกร้า
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
