<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavouriteController extends Controller
{   // ฟังก์ชันสำหรับการแสดงรายการโปรดของผู้ใช้
    public function index(): View
    {
        $userId = Auth::id();

        abort_unless($userId, 401);

        // ดึงรายการโปรดทั้งหมดของผู้ใช้ โดยจะโหลดข้อมูลสินค้าที่เกี่ยวข้อง (รวม category)
        $favorites = Favourite::with(['product.category'])
            ->where('user_id', $userId) // เงื่อนไขกรองเฉพาะรายการโปรดของผู้ใช้ที่มี user_id ตรงกับ $userId
            ->get();

        $filterOptions = $favorites
            ->map(function (Favourite $favourite) {
                return $favourite->product?->category?->name ?? 'Uncategorized';
            })
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $filterOptions = array_values(array_filter($filterOptions, fn ($value) => $value !== 'All'));

        array_unshift($filterOptions, 'All');

        // ส่งข้อมูล $favorites ไปยัง view favorites.index
        return view('favorites.index', [
            'favorites' => $favorites,
            'filterOptions' => $filterOptions,
        ]);
    }

    // ฟังก์ชันสำหรับ toggle สถานะของการเป็นรายการโปรดของสินค้า
    public function toggle(Request $request, Product $product): JsonResponse
    {
        $user = $request->user(); // ดึงข้อมูลผู้ใช้จาก (Request) เพื่อเช็คว่าผู้ใช้ล็อกอินไหม
        abort_unless($user, 401);

        // ใช้ belongsToMany บน User เพื่อ toggle รายการโปรด
        $toggled = $user->favourites()->toggle($product->getKey());

        return response()->json([
            'liked' => !empty($toggled['attached']), // ถ้ามีข้อมูลใน 'attached' หมายความว่าถูกเพิ่ม
        ]);
    }

    // ฟังก์ชันสำหรับการเพิ่มสินค้าลงในรายการโปรด
    public function store(Product $product): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user, 403);

        // ตรวจสอบว่าผู้ใช้ได้เพิ่มสินค้านี้เป็นรายการโปรดไปแล้วหรือไม่
        $alreadyFavorited = Favourite::where('user_id', $user->getKey()) 
            ->where('product_id', $product->getKey()) // เช็คว่ามีการเพิ่มสินค้าดังกล่าวในรายการโปรดแล้วหรือไม่
            ->exists(); // ตรวจสอบว่ามีข้อมูลนี้ในฐานข้อมูลหรือไม่

        if ($alreadyFavorited) {
            return redirect()
                ->route('favorites.show', $product)
                ->with('status', "{$product->name} is already in your favorites.");
        }

        Favourite::create([
            'user_id' => $user->getKey(),
            'product_id' => $product->getKey(),
        ]);

        return redirect()
            ->route('favorites.show', $product)
            ->with('status', "{$product->name} has been added to your favorites.");
    }

    public function show(Product $product): View
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $isFavorited = Favourite::where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->exists();

        abort_unless($isFavorited, 404);

        $product->loadMissing('category');

        return view('detail.index', [
            'product' => $product,
            'isFavorited' => true,
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $deleted = Favourite::where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->delete();

        abort_unless($deleted, 404);

        return redirect()
            ->route('favorites')
            ->with('status', "{$product->name} has been removed from your favorites.");
    }
}
