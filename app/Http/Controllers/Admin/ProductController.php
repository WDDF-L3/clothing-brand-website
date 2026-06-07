<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $products = $query->paginate(10)->withQueryString();
                $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'sizes'         => 'nullable|string', 
            'colors'        => 'nullable|string', 
        ]);

        $slug = Str::slug($request->name);
        if (Product::where('slug', $slug)->exists()) {
            $validated['slug'] = $slug . '-' . time();
        } else {
            $validated['slug'] = $slug;
        }

        $validated['sizes'] = $request->filled('sizes') ? array_map('trim', explode(',', $request->sizes)) : [];
        $validated['colors'] = $request->filled('colors') ? array_map('trim', explode(',', $request->colors)) : [];
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['images'] = []; // default blank image array

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); 
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'sizes'         => 'nullable|string', 
            'colors'        => 'nullable|string', 
        ]);

        $newSlug = Str::slug($request->name);
        if (Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
            $validated['slug'] = $newSlug . '-' . time();
        } else {
            $validated['slug'] = $newSlug;
        }

        $validated['sizes'] = $request->filled('sizes') ? array_map('trim', explode(',', $request->sizes)) : [];
        $validated['colors'] = $request->filled('colors') ? array_map('trim', explode(',', $request->colors)) : [];
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return redirect()->back()->with('success', 'Product status updated!');
    }
}