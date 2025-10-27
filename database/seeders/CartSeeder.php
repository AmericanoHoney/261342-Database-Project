<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\User;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('⚠️ No users found. Skipping cart creation.');
            return;
        }

        // ตรวจว่ามี column user_id ใน carts หรือไม่
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $this->command->info("🛒 Created cart for user {$user->email} (cart_id={$cart->id})");
    }
}
