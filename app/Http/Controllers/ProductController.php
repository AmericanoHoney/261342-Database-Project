<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = \App\Models\Product::query()
            ->with('category')
            ->when($userId, function ($q) use ($userId) {
                // Laravel 10+: เพิ่มคอลัมน์เสมือน is_favorited จาก pivot
                $q->withExists([
                    'favUsers as is_favorited' => fn($qq) => $qq->where('user_id', $userId),
                ]);
            });

        if ($search = $request->get('search')) {
            $query->where(fn($q) => $q->where('name','like',"%{$search}%")
                                    ->orWhere('description','like',"%{$search}%"));
        }
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }
        switch ($request->get('sort')) {
            case 'price_asc':  $query->orderBy('price'); break;
            case 'price_desc': $query->orderByDesc('price'); break;
            case 'name_asc':   $query->orderBy('name'); break;
            case 'name_desc':  $query->orderByDesc('name'); break;
            default:           $query->latest('updated_at');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();

        if (!$userId) {
            // guest: กัน null
            $products->getCollection()->each(fn($p) => $p->is_favorited = false);
        }

        return view('products.index', compact('products','categories'));
    }

    public function show(Product $product)
    {
        $product->loadMissing('category');

        $isFavorited = false;
        if ($userId = auth()->id()) {
            $isFavorited = Favourite::where('user_id', $userId)
                ->where('product_id', $product->getKey())
                ->exists();
        }

        return view('detail.index', [
            'product' => $product,
            'isFavorited' => $isFavorited,
        ]);
    }
}
