<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        $cart = Cart::first();
        if (!$cart) {
            $this->command->warn('⚠️ No cart found. Skipping CartItemSeeder.');
            return;
        }
        $products = Product::take(2)->get();

        foreach ($products as $p) {
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $p->product_id,
                'quantity' => rand(1, 3)
            ]);
        }
    }
}
