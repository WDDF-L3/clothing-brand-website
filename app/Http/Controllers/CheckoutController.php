<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index()
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items    = $this->cart->all();
        $subtotal = $this->cart->subtotal();
        $shipping = $this->cart->shippingCost();
        $total    = $this->cart->total();

        return view('checkout.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function place(Request $request)
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:30',
            'shipping_address' => 'required|string|max:500',
            'shipping_city'    => 'required|string|max:100',
            'shipping_state'   => 'required|string|max:100',
            'shipping_zip'     => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method'   => 'required|in:cod,bank_transfer',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                ...$validated,
                'subtotal'      => $this->cart->subtotal(),
                'shipping_cost' => $this->cart->shippingCost(),
                'total'         => $this->cart->total(),
                'status'        => 'pending',
            ]);

            foreach ($this->cart->all() as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'size'         => $item['size'],
                    'color'        => $item['color'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['price'],
                    'total_price'  => $item['price'] * $item['quantity'],
                ]);
            }

            $this->cart->clear();

            return $order;
        });

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
