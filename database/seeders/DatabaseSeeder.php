<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Elegant womenswear collections'],
            ['name' => 'Men',   'slug' => 'men',   'description' => 'Refined menswear essentials'],
            ['name' => 'Bags',  'slug' => 'bags',  'description' => 'Luxury bags & accessories'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Designer footwear'],
        ];

        foreach ($categories as $cat) {
            Category::create([...$cat, 'is_active' => true]);
        }

        $womenId = Category::where('slug', 'women')->value('id');
        $menId   = Category::where('slug', 'men')->value('id');
        $bagsId  = Category::where('slug', 'bags')->value('id');
        $shoesId = Category::where('slug', 'shoes')->value('id');

        $products = [
            // Women
            [
                'category_id'   => $womenId,
                'name'          => 'Silk Draped Midi Dress',
                'price'         => 289.00,
                'compare_price' => 360.00,
                'stock'         => 15,
                'sizes'         => ['XS', 'S', 'M', 'L', 'XL'],
                'colors'        => ['Ivory', 'Blush', 'Noir'],
                'is_featured'   => true,
                'description'   => 'A timeless silk draped midi dress with a fluid silhouette. Cut from the finest Italian silk, this dress effortlessly transitions from day to evening wear.',
            ],
            [
                'category_id'   => $womenId,
                'name'          => 'Linen Wide-Leg Trousers',
                'price'         => 159.00,
                'compare_price' => null,
                'stock'         => 22,
                'sizes'         => ['XS', 'S', 'M', 'L'],
                'colors'        => ['Sand', 'White', 'Sage'],
                'is_featured'   => true,
                'description'   => 'Relaxed wide-leg trousers crafted from premium European linen. The perfect summer essential for effortless style.',
            ],
            [
                'category_id'   => $womenId,
                'name'          => 'Cashmere Turtleneck Sweater',
                'price'         => 320.00,
                'compare_price' => 400.00,
                'stock'         => 8,
                'sizes'         => ['S', 'M', 'L', 'XL'],
                'colors'        => ['Camel', 'Oatmeal', 'Black'],
                'is_featured'   => false,
                'description'   => 'Ultra-soft pure cashmere turtleneck. A wardrobe investment that only gets better with time.',
            ],
            [
                'category_id'   => $womenId,
                'name'          => 'Structured Blazer',
                'price'         => 445.00,
                'compare_price' => null,
                'stock'         => 12,
                'sizes'         => ['XS', 'S', 'M', 'L', 'XL'],
                'colors'        => ['Chalk', 'Charcoal'],
                'is_featured'   => true,
                'description'   => 'A sharp, structured blazer with a modern silhouette. Tailored in Italy from a fine wool blend.',
            ],
            // Men
            [
                'category_id'   => $menId,
                'name'          => 'Merino Wool Crewneck',
                'price'         => 185.00,
                'compare_price' => null,
                'stock'         => 30,
                'sizes'         => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors'        => ['Navy', 'Forest', 'Burgundy', 'Grey'],
                'is_featured'   => true,
                'description'   => 'A perfectly weighted merino wool crewneck sweater. Breathable, soft, and built to last a decade.',
            ],
            [
                'category_id'   => $menId,
                'name'          => 'Slim Fit Chinos',
                'price'         => 139.00,
                'compare_price' => 175.00,
                'stock'         => 40,
                'sizes'         => ['28', '30', '32', '34', '36'],
                'colors'        => ['Khaki', 'Navy', 'Olive'],
                'is_featured'   => false,
                'description'   => 'Classic slim-fit chinos made from a stretch cotton blend. Versatile enough for the office and weekends.',
            ],
            [
                'category_id'   => $menId,
                'name'          => 'Oxford Button-Down Shirt',
                'price'         => 115.00,
                'compare_price' => null,
                'stock'         => 25,
                'sizes'         => ['S', 'M', 'L', 'XL'],
                'colors'        => ['White', 'Blue', 'Pink'],
                'is_featured'   => false,
                'description'   => 'The quintessential Oxford cloth button-down. Crisp, breathable, and endlessly versatile.',
            ],
            // Bags
            [
                'category_id'   => $bagsId,
                'name'          => 'Mini Leather Shoulder Bag',
                'price'         => 395.00,
                'compare_price' => null,
                'stock'         => 7,
                'sizes'         => [],
                'colors'        => ['Black', 'Tan', 'Burgundy'],
                'is_featured'   => true,
                'description'   => 'A compact, beautifully crafted shoulder bag in full-grain leather. Features a gold-tone chain strap and magnetic closure.',
            ],
            [
                'category_id'   => $bagsId,
                'name'          => 'Canvas Tote Bag',
                'price'         => 75.00,
                'compare_price' => null,
                'stock'         => 50,
                'sizes'         => [],
                'colors'        => ['Natural', 'Black'],
                'is_featured'   => false,
                'description'   => 'A spacious, durable canvas tote. Reinforced handles and an interior zip pocket keep you organized in style.',
            ],
            // Shoes
            [
                'category_id'   => $shoesId,
                'name'          => 'Leather Chelsea Boots',
                'price'         => 325.00,
                'compare_price' => 420.00,
                'stock'         => 14,
                'sizes'         => ['36', '37', '38', '39', '40', '41'],
                'colors'        => ['Black', 'Tan'],
                'is_featured'   => true,
                'description'   => 'Handcrafted Chelsea boots in supple calfskin leather. Elastic gussets and a pull tab for easy wear.',
            ],
            [
                'category_id'   => $shoesId,
                'name'          => 'White Leather Sneakers',
                'price'         => 195.00,
                'compare_price' => null,
                'stock'         => 20,
                'sizes'         => ['36', '37', '38', '39', '40', '41', '42'],
                'colors'        => ['White'],
                'is_featured'   => false,
                'description'   => 'Minimalist leather sneakers with a cushioned sole. The modern classic for any wardrobe.',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                ...$product,
                'slug'      => Str::slug($product['name']),
                'images'    => [],
                'is_active' => true,
            ]);
        }
    }
}
