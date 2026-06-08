<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_shop_page_loads_successfully(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
    }

    public function test_cart_page_loads_successfully(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_checkout_redirects_when_cart_empty(): void
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/cart');
    }
}
