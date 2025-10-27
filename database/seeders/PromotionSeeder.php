<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::query()->delete(); // ล้างก่อน (ถ้าไม่อยากล้างให้ลบออก)

        $promotions = [
            [
                'name' => '15% OFF ช้อปเลยวันนี้',
                'promotion_photo' => 'images/promotions/promo15.jpg',
                'discount_percent' => 15,
                'active' => true,
            ],
            [
                'name' => 'Spring Sale 30%',
                'promotion_photo' => 'images/promotions/promo30.jpg',
                'discount_percent' => 30,
                'active' => true,
            ],
            [
                'name' => 'Special Offer 30%',
                'promotion_photo' => 'images/promotions/promo30special.jpg',
                'discount_percent' => 30,
                'active' => true,
            ],
            [
                'name' => 'Flash Sale 25%',
                'promotion_photo' => 'images/promotions/promo25.jpg',
                'discount_percent' => 25,
                'active' => false,
            ],
        ];

        foreach ($promotions as $p) {
            Promotion::create($p);
        }
    }
}
