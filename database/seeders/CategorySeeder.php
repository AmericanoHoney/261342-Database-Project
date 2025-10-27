<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Flower Bouquets',
            'Flower Baskets',
            'Dried Flowers',
            'Single Blossom',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
