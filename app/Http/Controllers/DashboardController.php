<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $promotions = Promotion::where('active', true)
            ->latest('updated_at')
            ->take(10)
            ->get(['promotion_id','name','promotion_photo','discount_percent','active']);

        $products = Product::query()
            ->with('category')
            ->when($userId, function ($q) use ($userId) {
                // คำนวณสถานะ fav ของ user ปัจจุบัน
                $q->withExists([
                    'favUsers as is_favorited' => fn($qq) => $qq->where('user_id', $userId),
                ]);
            })
            ->latest('updated_at')
            ->take(8)
            ->get(['product_id','name','price','image_url','category_id']);

        if (!$userId) {
            $products->each(fn($p) => $p->is_favorited = false);
        }

        return view('dashboard', compact('promotions', 'products'));
    }
}
