<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    public function show(Product $product)
    {
        $query = Product::with('category');
        $product->loadMissing('category');

        // Search by keyword (name or description)
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $userId = auth()->id();

        // Filter by category
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }
        $isFavorited = false;

        // Sort options
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest('updated_at');
        if ($userId) {
            $isFavorited = Favourite::where('user_id', $userId)
                ->where('product_id', $product->getKey())
                ->exists();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
        return view('detail.index', [
            'product' => $product,
            'isFavorited' => $isFavorited,
        ]);
    }
}
