<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Order::create([
            'user_id' => $user->id,
            'order_date' => Carbon::now(),
            'subtotal' => 1200.00,
            'total_price' => 1080.00,
            'status' => 'Pending'
        ]);
    }
}
