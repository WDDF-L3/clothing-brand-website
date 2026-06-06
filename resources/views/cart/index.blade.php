@extends('layouts.app')

@section('title', 'Shopping Bag')
@section('no-catbar', true)

@section('content')

<div style="padding: 48px 0;" class="container">

    <div style="text-align:center; margin-bottom:48px;">
        <h1 class="serif" style="font-size:48px; font-weight:300;">Your Bag</h1>
        <p style="color:var(--muted); font-size:12px; margin-top:4px;">{{ $items->count() }} {{ Str::plural('item', $items->count()) }}</p>
    </div>

    @if($items->isEmpty())
    <div style="text-align:center; padding:80px 0;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--stone)" stroke-width="1.5" style="margin:0 auto 20px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <p class="serif" style="font-size:28px; color:var(--muted); margin-bottom:24px;">Your bag is empty.</p>
        <a href="{{ route('shop') }}" class="btn btn-dark">Continue Shopping</a>
    </div>

    @else
    <div style="display:grid; grid-template-columns:1fr 360px; gap:48px; align-items:start;">

        {{-- Items --}}
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div style="display:flex; gap:16px; align-items:center;">
                                <a href="{{ route('products.show', $item['slug']) }}" style="flex-shrink:0;">
                                    <div style="width:64px; height:80px; background:var(--warm); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                        @if($item['image'] && !str_contains($item['image'], 'placehold'))
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <span style="font-size:9px; color:var(--stone); text-align:center; padding:4px;">{{ $item['name'] }}</span>
                                        @endif
                                    </div>
                                </a>
                                <div>
                                    <a href="{{ route('products.show', $item['slug']) }}" style="font-family:'Cormorant Garamond',serif; font-size:18px; display:block; margin-bottom:4px;">
                                        {{ $item['name'] }}
                                    </a>
                                    @if($item['size'])
                                        <span style="font-size:11px; color:var(--muted); letter-spacing:.08em;">Size: {{ $item['size'] }}</span>
                                    @endif
                                    @if($item['color'])
                                        <span style="font-size:11px; color:var(--muted); margin-left:8px;">· {{ $item['color'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item['row_id']) }}" method="POST" style="display:flex; align-items:center; gap:4px;">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="10" class="form-control" style="width:60px; padding:6px; text-align:center; font-size:13px;">
                                <button type="submit" class="btn btn-outline btn-sm">✓</button>
                            </form>
                        </td>
                        <td style="font-weight:500;">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item['row_id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none; border:none; cursor:pointer; color:var(--muted); font-size:18px;" title="Remove">×</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:24px;">
                <a href="{{ route('shop') }}" class="btn btn-outline btn-sm">← Continue Shopping</a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm" style="background:none; color:var(--muted); border:1px solid var(--border);" onclick="return confirm('Clear entire bag?')">
                        Clear Bag
                    </button>
                </form>
            </div>
        </div>

        {{-- Summary --}}
        <div style="background:var(--warm); padding:32px; border:1px solid var(--border); position:sticky; top:88px;">
            <h2 class="serif" style="font-size:24px; margin-bottom:24px;">Order Summary</h2>

            <div style="display:grid; gap:12px; margin-bottom:24px; font-size:14px;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:var(--muted);">Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:var(--muted);">Shipping</span>
                    <span>
                        @if($shipping == 0)
                            <span style="color:var(--success);">Free</span>
                        @else
                            ${{ number_format($shipping, 2) }}
                        @endif
                    </span>
                </div>
                @if($shipping > 0)
                <p style="font-size:11px; color:var(--muted); letter-spacing:.05em;">
                    Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping
                </p>
                @endif
                <div style="display:flex; justify-content:space-between; padding-top:12px; border-top:1px solid var(--border); font-size:18px; font-family:'Cormorant Garamond',serif;">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn btn-dark" style="width:100%; justify-content:center; padding:16px;">
                Proceed to Checkout
            </a>

            <p style="text-align:center; margin-top:16px; font-size:11px; color:var(--muted); letter-spacing:.08em;">
                30-day free returns · Secure checkout
            </p>
        </div>
    </div>
    @endif
</div>

@endsection
