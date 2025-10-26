<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Rose Bouquet',
                'price' => 1200.00,
                'stock' => 20,
                'description' => 'A lovely bouquet of red roses.',
                'image_url' => 'images/products/rose-bouquet.jpg',
                'category_id' => 2
            ],
            [
                'name' => 'Orchid Pot',
                'price' => 650.00,
                'stock' => 15,
                'description' => 'Elegant orchids in a ceramic pot.',
                'image_url' => 'images/products/orchid-pot.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Gift Box Set',
                'price' => 950.00,
                'stock' => 10,
                'description' => 'Perfect for birthdays and special occasions.',
                'image_url' => 'images/products/gift-box.jpg',
                'category_id' => 3
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
