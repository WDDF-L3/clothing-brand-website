@extends('layouts.app')

@section('title', 'Order Confirmed')
@section('no-catbar', true)

@section('content')

<div style="padding: 80px 0; text-align:center;" class="container">

    <div style="max-width: 560px; margin: 0 auto;">
        <div style="width:64px; height:64px; border-radius:50%; background:var(--success); display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>

        <h1 class="serif" style="font-size:48px; font-weight:300; margin-bottom:12px;">Order Confirmed</h1>
        <p style="color:var(--muted); font-size:14px; line-height:1.8; margin-bottom:32px;">
            Thank you, <strong>{{ $order->customer_name }}</strong>! Your order has been placed successfully.
            A confirmation will be sent to <strong>{{ $order->customer_email }}</strong>.
        </p>

        <div style="background:var(--warm); border:1px solid var(--border); padding:28px; text-align:left; margin-bottom:32px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                <div>
                    <p style="font-size:10px; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); margin-bottom:4px;">Order Number</p>
                    <p style="font-family:'Cormorant Garamond',serif; font-size:22px;">{{ $order->order_number }}</p>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:10px; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); margin-bottom:4px;">Status</p>
                    <span style="background:var(--ink); color:var(--cream); font-size:10px; padding:4px 10px; letter-spacing:.1em; text-transform:uppercase;">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            {{-- Items --}}
            <div style="border-top:1px solid var(--border); padding-top:16px; margin-bottom:16px;">
                @foreach($order->items as $item)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:13px; border-bottom:1px solid var(--border);">
                    <div>
                        <span style="font-family:'Cormorant Garamond',serif; font-size:16px;">{{ $item->product_name }}</span>
                        @if($item->size) <span style="color:var(--muted); font-size:11px;"> · {{ $item->size }}</span>@endif
                        <span style="color:var(--muted); font-size:11px;"> × {{ $item->quantity }}</span>
                    </div>
                    <span>${{ number_format($item->total_price, 2) }}</span>
                </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div style="display:grid; gap:8px; font-size:13px;">
                <div style="display:flex; justify-content:space-between; color:var(--muted);">
                    <span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; color:var(--muted);">
                    <span>Shipping</span>
                    <span>@if($order->shipping_cost == 0) Free @else ${{ number_format($order->shipping_cost, 2) }} @endif</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding-top:8px; border-top:1px solid var(--border); font-size:17px; font-family:'Cormorant Garamond',serif;">
                    <span>Total</span><span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div style="background:white; border:1px solid var(--border); padding:20px; text-align:left; margin-bottom:32px;">
            <p style="font-size:10px; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Shipping To</p>
            <p style="font-size:14px; line-height:1.8;">
                {{ $order->customer_name }}<br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                {{ $order->shipping_country }}
            </p>
        </div>

        <div style="display:flex; gap:12px; justify-content:center;">
            <a href="{{ route('shop') }}" class="btn btn-dark">Continue Shopping</a>
            <a href="{{ route('home') }}" class="btn btn-outline">Back to Home</a>
        </div>
    </div>
</div>

@endsection
