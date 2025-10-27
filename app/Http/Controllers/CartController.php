<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        // หา cart ของ user ปัจจุบัน หรือสร้างใหม่ถ้าไม่มี
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product'); // โหลดสินค้าที่อยู่ในตะกร้า

        return view('cart.index', compact('cart'));
    }
}
