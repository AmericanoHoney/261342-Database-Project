<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Promotion;

class DashboardController extends Controller
{
    public function index()
    {
        $promotions = Promotion::where('active', true)
            ->latest('updated_at')
            ->take(10)
            ->get(['promotion_id','name','promotion_photo','discount_percent','active']);

        return view('dashboard', compact('promotions'));
    }
}
