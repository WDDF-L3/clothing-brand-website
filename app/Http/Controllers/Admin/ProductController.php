<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products   = $query->paginate(10)->withQueryString();
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
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'sizes'         => 'nullable|string',
            'colors'        => 'nullable|string',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Slug
        $slug = Str::slug($request->name);
        $slug = Product::where('slug', $slug)->exists() ? $slug . '-' . time() : $slug;

        // Upload images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $imagePaths[] = '/storage/' . $path;
            }
        }

        Product::create([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'slug'          => $slug,
            'description'   => $request->description,
            'price'         => $request->price,
            'compare_price' => $request->compare_price,
            'stock'         => $request->stock,
            'sizes'         => $request->filled('sizes')
                                ? array_map('trim', explode(',', $request->sizes))
                                : [],
            'colors'        => $request->filled('colors')
                                ? array_map('trim', explode(',', $request->colors))
                                : [],
            // ✅ Checkboxes: true if checked, false if not — NOT using $request->has()
            'is_active'     => $request->input('is_active', 0) == 1,
            'is_featured'   => $request->input('is_featured', 0) == 1,
            'images'        => $imagePaths,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'sizes'         => 'nullable|string',
            'colors'        => 'nullable|string',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Slug
        $newSlug = Str::slug($request->name);
        $newSlug = Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()
            ? $newSlug . '-' . time()
            : $newSlug;

        // ── Images: keep existing unless new ones uploaded ────────
        $imagePaths = $product->images ?? []; // default = keep existing

        if ($request->hasFile('images')) {
            // Delete old images from disk
            foreach ($product->images ?? [] as $oldImage) {
                if (Str::startsWith($oldImage, '/storage/')) {
                    Storage::disk('public')->delete(Str::after($oldImage, '/storage/'));
                }
            }
            // Store new images
            $imagePaths = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $imagePaths[] = '/storage/' . $path;
            }
        }
        // ─────────────────────────────────────────────────────────

        $product->update([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'slug'          => $newSlug,
            'description'   => $request->description,
            'price'         => $request->price,
            'compare_price' => $request->compare_price,
            'stock'         => $request->stock,
            'sizes'         => $request->filled('sizes')
                                ? array_map('trim', explode(',', $request->sizes))
                                : [],
            'colors'        => $request->filled('colors')
                                ? array_map('trim', explode(',', $request->colors))
                                : [],
            // ✅ KEY FIX: input('is_active', 0) returns 0 when checkbox unchecked
            //    $request->has('is_active') returns false when unchecked — WRONG
            'is_active'     => $request->input('is_active', 0) == 1,
            'is_featured'   => $request->input('is_featured', 0) == 1,
            'images'        => $imagePaths,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete images from disk
        foreach ($product->images ?? [] as $image) {
            if (Str::startsWith($image, '/storage/')) {
                Storage::disk('public')->delete(Str::after($image, '/storage/'));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return redirect()->back()->with('success', 'Product status updated!');
    }
}