<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('category_id', 'name');

        $sampleProducts = [
            'Flower Bouquets' => [
                'Rose Romance', 'Tulip Treasure', 'Peony Passion', 'Lily Love', 'Carnation Charm',
                'Mixed Spring', 'Pastel Dream', 'Sunshine Bouquet', 'Evening Glow', 'Classic Elegance',
            ],
            'Flower Baskets' => [
                'Morning Basket', 'Rustic Charm', 'Sweet Serenity', 'Blossom Basket', 'Delightful Daisies',
                'Warm Wishes', 'Floral Fantasy', 'Soft Petals', 'Cheerful Day', 'Graceful Gift',
            ],
            'Dried Flowers' => [
                'Golden Wheat', 'Lavender Bliss', 'Rustic Rose', 'Vintage Garden', 'Dried Harmony',
                'Muted Meadow', 'Forever Bloom', 'Autumn Whisper', 'Natural Charm', 'Country Calm',
            ],
            'Single Blossom' => [
                'Single Red Rose', 'Pure White Lily', 'Golden Sunflower', 'Pink Tulip', 'Blue Hydrangea',
                'Orchid Elegance', 'White Carnation', 'Orange Gerbera', 'Violet Charm', 'Crimson Peony',
            ],
        ];

        foreach ($sampleProducts as $categoryName => $products) {
            $categoryId = $categories[$categoryName] ?? null;
            if (!$categoryId) continue;

            foreach ($products as $name) {
                Product::create([
                    'name' => $name,
                    'price' => rand(300, 1500),
                    'stock' => rand(5, 30),
                    'description' => 'Beautiful ' . strtolower($categoryName) . ' arrangement named "' . $name . '".',
                    'image_url' => 'images/products/' . str_replace(' ', '-', strtolower($name)) . '.jpg',
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
