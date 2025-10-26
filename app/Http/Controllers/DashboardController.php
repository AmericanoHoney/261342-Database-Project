<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $promotions = Promotion::where('active', true)
            ->latest('updated_at')
            ->take(10)
            ->get(['promotion_id','name','promotion_photo','discount_percent','active']);

        $products = Product::with('category')
            ->latest() // อิง created_at/updated_at
            ->take(8)
            ->get(['product_id','name','price','image_url','category_id']);

        return view('dashboard', compact('promotions', 'products'));
    }
}
