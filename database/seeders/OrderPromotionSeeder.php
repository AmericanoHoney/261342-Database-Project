<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\OrderPromotion;

class OrderPromotionSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();
        $promo = Promotion::first();

        OrderPromotion::create([
            'order_id' => $order->order_id,
            'promotion_id' => $promo->promotion_id
        ]);
    }
}
