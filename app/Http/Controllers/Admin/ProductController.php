<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($category = $request->get('category')) {
            $query->where('category_id', $category);
        }

        $products   = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data = $this->processData($request, $data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product->id);
        $data = $this->processData($request, $data, $product);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete stored images from disk
        foreach ($product->images ?? [] as $img) {
            if (Str::startsWith($img, '/storage/')) {
                Storage::disk('public')->delete(Str::after($img, '/storage/'));
            }
        }
        $product->delete();
        return back()->with('success', "'{$product->name}' deleted.");
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);
        return back()->with('success', 'Product status updated.');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'sizes'         => 'nullable|string',
            'colors'        => 'nullable|string',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'is_featured'   => 'nullable|boolean',
            'is_active'     => 'nullable|boolean',
        ]);
    }

    private function processData(Request $request, array $data, ?Product $product = null): array
    {
        // Generate slug
        $data['slug'] = Str::slug($data['name']);

        // Sizes & colors: comma-separated string → array
        $data['sizes']  = $this->toArray($data['sizes']  ?? '');
        $data['colors'] = $this->toArray($data['colors'] ?? '');

        // Handle uploaded images
        $existingImages = $product ? ($product->images ?? []) : [];

        if ($request->hasFile('images')) {
            $newPaths = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $newPaths[] = '/storage/' . $path;
            }
            // New uploads replace existing images
            $data['images'] = array_merge($newPaths, $existingImages);
        } else {
            $data['images'] = $existingImages;
        }

        unset($data['images.*']); // remove validation key

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        return $data;
    }

    private function toArray(string $value): array
    {
        if (empty(trim($value))) return [];
        return array_map('trim', explode(',', $value));
    }
}
