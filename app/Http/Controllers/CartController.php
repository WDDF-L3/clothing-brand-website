<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index()
    {
        $items    = $this->cart->all();
        $subtotal = $this->cart->subtotal();
        $shipping = $this->cart->shippingCost();
        $total    = $this->cart->total();

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'sometimes|integer|min:1|max:10',
            'size'     => 'sometimes|string',
            'color'    => 'sometimes|string',
        ]);

        if ($product->stock < 1) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $this->cart->add(
            $product,
            $request->input('quantity', 1),
            $request->input('size'),
            $request->input('color'),
        );

        return back()->with('success', "\"{$product->name}\" added to your cart!");
    }

    public function update(Request $request, string $rowId)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:10']);
        $this->cart->update($rowId, $request->input('quantity'));

        return back()->with('success', 'Cart updated.');
    }

    public function remove(string $rowId)
    {
        $this->cart->remove($rowId);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
