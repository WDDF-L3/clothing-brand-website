<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->withCount('products')->get();
        $query = Product::active()->inStock()->with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categorySlug = $request->get('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($size = $request->get('size')) {
            $query->whereJsonContains('sizes', $size);
        }

        match ($request->get('sort', 'newest')) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products  = $query->paginate(12)->withQueryString();
        $featured  = Product::active()->featured()->inStock()->with('category')->take(4)->get();

        return view('products.index', compact('products', 'categories', 'featured'));
    }

    public function show(Product $product)
    {
        abort_if(! $product->is_active, 404);

        $related = Product::active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }

    public function category(Category $category)
    {
        abort_if(! $category->is_active, 404);

        $products   = $category->products()->active()->inStock()->latest()->paginate(12);
        $categories = Category::active()->withCount('products')->get();

        return view('products.category', compact('category', 'products', 'categories'));
    }
}