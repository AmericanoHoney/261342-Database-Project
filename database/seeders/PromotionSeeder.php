<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::create([
            'name' => 'Summer Sale',
            'discount_percent' => 10,
            'active' => true
        ]);
    }
}
