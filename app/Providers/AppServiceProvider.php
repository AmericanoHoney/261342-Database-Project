<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View composer ส่ง $user ไปทุก layout ที่ใช้ navbar
        View::composer('layouts.app', function ($view) {
            $view->with('user', Auth::user());
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = CartItem::whereHas('cart', function($q) {
                    $q->where('user_id', Auth::id());
                })->sum('quantity');
            }
            $view->with('cartCount', $cartCount);
            });
    }
}
