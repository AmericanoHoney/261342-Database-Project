<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index()
    {
        // หา cart ของ user ปัจจุบัน หรือสร้างใหม่ถ้าไม่มี
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product'); // โหลดสินค้าที่อยู่ในตะกร้า

        return view('cart.index', compact('cart'));
    }

    // รับคำสั่ง “Add to cart”
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', Rule::exists('products', 'product_id')],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < 1) {
            return back()->with('error', __('This product is currently out of stock.'));
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->where('product_id', $product->getKey())->first();
        $requestedQuantity = (int) $data['quantity'];
        $existingQuantity = $cartItem?->quantity ?? 0;
        $desiredQuantity = $requestedQuantity + $existingQuantity;

        $availableQuantity = max(0, (int) $product->stock);
        $finalQuantity = min($desiredQuantity, $availableQuantity);

        if ($finalQuantity < 1) {
            return back()->with('error', __('Unable to add this product to the cart at the moment.'));
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $finalQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->getKey(),
                'quantity' => $finalQuantity,
            ]);
        }

        $message = __('Product added to cart.');

        if ($finalQuantity <= $existingQuantity) {
            $message = __('You already have the maximum available quantity for this product in your cart.');
        } elseif ($finalQuantity < $desiredQuantity) {
            $added = $finalQuantity - $existingQuantity;
            $message = __('Only :count piece(s) were available and have been added to your cart.', ['count' => $added]);
        }

        return redirect()->route('cart.index')->with('success', $message);
    }
}
