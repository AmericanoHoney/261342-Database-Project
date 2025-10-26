<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favourite;
use App\Models\User;
use App\Models\Product;

class FavouriteSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $products = Product::inRandomOrder()->take(2)->get();

        foreach ($products as $p) {
            Favourite::create([
                'user_id' => $user->id,
                'product_id' => $p->product_id
            ]);
        }
    }
}
