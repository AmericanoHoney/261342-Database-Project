<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\OrderPromotion;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();
        $promotions = Promotion::where('active', true)->get();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty 💔');
        }

        // คำนวณราคารวม
        $subtotal = $cart->items->sum(fn($item) => $item->subtotal());
        return view('checkout.index', compact('cart', 'promotions', 'subtotal'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty 💔');
        }

        $request->validate([
            'delivery_date' => 'required|date',
            'delivery_time' => 'required',
            'promotion_id' => 'nullable|exists:promotions,promotion_id',
            'address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $promotion = Promotion::find($request->promotion_id);
            $discountRate = $promotion ? ($promotion->discount_percent / 100) : 0;

            $subtotal = $cart->items->sum(fn($item) => $item->subtotal());
            $discount = $subtotal * $discountRate;
            $total = $subtotal - $discount;

            $order = Order::create([
                'user_id' => $user->id,
                'order_date' => now(),
                'subtotal' => $subtotal,
                'total_price' => $total,
                'status' => 'Pending',
                'delivery_date' => $request->delivery_date,
                'delivery_time' => $request->delivery_time,
                'delivery_address' => $request->address,
            ]);

            foreach ($cart->items as $item) {
                $product = $item->product;

                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart.index')
                        ->with('status', "❌ Not enough stock for {$product->name}");
                }

                $product->stock -= $item->quantity;
                $product->save();

                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
            }

            if ($promotion) {
                OrderPromotion::create([
                    'order_id' => $order->order_id,
                    'promotion_id' => $promotion->promotion_id,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('orders.history')
                    ->with('status', "✅ Order placed successfully! See your history below.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('status', 'Error: ' . $e->getMessage());
        }
    }
}
