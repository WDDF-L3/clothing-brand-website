<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::create([
            'name'      => 'Women',
            'slug'      => 'women',
            'is_active' => true,
        ]);

        return Product::create(array_merge([
            'category_id'   => $category->id,
            'name'          => 'Test Dress',
            'slug'          => 'test-dress',
            'price'         => 99.99,
            'stock'         => 10,
            'sizes'         => ['S', 'M', 'L'],
            'colors'        => ['Black'],
            'images'        => [],
            'is_active'     => true,
            'is_featured'   => false,
        ], $overrides));
    }

    public function test_can_add_product_to_cart(): void
    {
        $product = $this->createProduct();

        $response = $this->post("/cart/add/{$product->id}", [
            'quantity' => 1,
            'size'     => 'M',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_cannot_add_out_of_stock_product(): void
    {
        $product = $this->createProduct(['stock' => 0]);

        $response = $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_can_clear_cart(): void
    {
        $response = $this->delete('/cart/clear');
        $response->assertRedirect('/cart');
    }
}
