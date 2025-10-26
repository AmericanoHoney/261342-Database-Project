<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favourite;

class FavouriteSeeder extends Seeder
{
    public function run(): void
    {
        Favourite::create([
            'user_id' => 1,
            'product_id' => 1
        ]);

        Favourite::create([
            'user_id' => 1,
            'product_id' => 2
        ]);
    }
}
