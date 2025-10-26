<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function history()
    {
        $user = Auth::user();

        $orders = Order::with('details.product', 'promotions')
            ->where('user_id', $user->id)
            ->orderBy('order_date', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('details.product', 'promotions')->findOrFail($id);

        $discountPercent = $order->promotions->first()->discount_percent ?? 0;
        $discountAmount = ($order->total_price * $discountPercent) / 100;
        $finalTotal = $order->total_price;

        return response()->json([
            'order_id' => $order->order_id,
            'status' => $order->status,
            'order_date' => $order->order_date,
            'delivery_date' => $order->delivery_date,
            'address' => $order->address,
            'subtotal' => $order->subtotal,
            'total_price' => $order->total_price,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'final_total' => $finalTotal,
            'details' => $order->details->map(function ($detail) {
                return [
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->price,
                    'subtotal' => $detail->quantity * $detail->price,
                ];
            }),
            'promotions' => $order->promotions->map(function ($promo) {
                return [
                    'name' => $promo->name,
                    'discount_percent' => $promo->discount_percent,
                ];
            }),
        ]);
    }
}
