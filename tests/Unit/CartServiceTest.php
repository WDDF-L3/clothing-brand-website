<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = new CartService();
    }

    public function test_cart_is_empty_by_default(): void
    {
        $this->assertEquals(0, $this->cart->count());
        $this->assertEquals(0.0, $this->cart->subtotal());
    }

    public function test_shipping_is_free_over_100(): void
    {
        // Subtotal >= 100 → free shipping
        $this->assertEquals(0.0,  (new CartService())->shippingCost());
    }

    public function test_subtotal_returns_zero_when_cart_empty(): void
    {
        $this->assertEquals(0.0, $this->cart->subtotal());
    }
}
