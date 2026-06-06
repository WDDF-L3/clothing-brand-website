<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    protected string $sessionKey = 'shopping_cart';

    // ─── Retrieve ────────────────────────────────────────────────────────────

    public function all(): Collection
    {
        return collect(Session::get($this->sessionKey, []));
    }

    public function count(): int
    {
        return $this->all()->sum('quantity');
    }

    public function subtotal(): float
    {
        return $this->all()->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public function total(): float
    {
        return $this->subtotal() + $this->shippingCost();
    }

    public function shippingCost(): float
    {
        return $this->subtotal() >= 100 ? 0.0 : 9.99;
    }

    // ─── Mutate ───────────────────────────────────────────────────────────────

    public function add(Product $product, int $quantity = 1, ?string $size = null, ?string $color = null): void
    {
        $cart = $this->all();
        $rowId = $this->generateRowId($product->id, $size, $color);

        if ($cart->has($rowId)) {
            $item = $cart->get($rowId);
            $item['quantity'] += $quantity;
            $cart->put($rowId, $item);
        } else {
            $cart->put($rowId, [
                'row_id'    => $rowId,
                'product_id'=> $product->id,
                'name'      => $product->name,
                'slug'      => $product->slug,
                'image'     => $product->primary_image,
                'price'     => (float) $product->price,
                'size'      => $size,
                'color'     => $color,
                'quantity'  => $quantity,
            ]);
        }

        Session::put($this->sessionKey, $cart->all());
    }

    public function update(string $rowId, int $quantity): void
    {
        $cart = $this->all();

        if ($cart->has($rowId)) {
            if ($quantity <= 0) {
                $this->remove($rowId);
                return;
            }
            $item = $cart->get($rowId);
            $item['quantity'] = $quantity;
            $cart->put($rowId, $item);
            Session::put($this->sessionKey, $cart->all());
        }
    }

    public function remove(string $rowId): void
    {
        $cart = $this->all()->forget($rowId);
        Session::put($this->sessionKey, $cart->all());
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    protected function generateRowId(int $productId, ?string $size, ?string $color): string
    {
        return md5($productId . ($size ?? '') . ($color ?? ''));
    }
}
