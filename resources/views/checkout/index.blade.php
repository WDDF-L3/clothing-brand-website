@extends('layouts.app')

@section('title', 'Checkout')
@section('no-catbar', true)

@section('content')

<div style="padding: 48px 0;" class="container">

    <div style="text-align:center; margin-bottom:48px;">
        <h1 class="serif" style="font-size:48px; font-weight:300;">Checkout</h1>
    </div>

    <div style="display:grid; grid-template-columns:1fr 380px; gap:64px; align-items:start;">

        {{-- Form --}}
        <div>
            <form action="{{ route('checkout.place') }}" method="POST">
                @csrf

                {{-- Customer Info --}}
                <div style="margin-bottom:40px;">
                    <h2 class="serif" style="font-size:26px; margin-bottom:24px;">Contact Information</h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="form-group" style="grid-column:1/-1;">
                            <label class="form-label" for="customer_name">Full Name</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                            @error('customer_name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customer_email">Email</label>
                            <input type="email" id="customer_email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                            @error('customer_email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customer_phone">Phone</label>
                            <input type="tel" id="customer_phone" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Shipping --}}
                <div style="margin-bottom:40px;">
                    <h2 class="serif" style="font-size:26px; margin-bottom:24px;">Shipping Address</h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="form-group" style="grid-column:1/-1;">
                            <label class="form-label" for="shipping_address">Street Address</label>
                            <input type="text" id="shipping_address" name="shipping_address" class="form-control" value="{{ old('shipping_address') }}" required>
                            @error('shipping_address')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="shipping_city">City</label>
                            <input type="text" id="shipping_city" name="shipping_city" class="form-control" value="{{ old('shipping_city') }}" required>
                            @error('shipping_city')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="shipping_state">State / Province</label>
                            <input type="text" id="shipping_state" name="shipping_state" class="form-control" value="{{ old('shipping_state') }}" required>
                            @error('shipping_state')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="shipping_zip">ZIP / Postal Code</label>
                            <input type="text" id="shipping_zip" name="shipping_zip" class="form-control" value="{{ old('shipping_zip') }}" required>
                            @error('shipping_zip')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="shipping_country">Country</label>
                            <input type="text" id="shipping_country" name="shipping_country" class="form-control" value="{{ old('shipping_country', 'United States') }}" required>
                            @error('shipping_country')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div style="margin-bottom:40px;">
                    <h2 class="serif" style="font-size:26px; margin-bottom:24px;">Payment Method</h2>
                    <div style="display:grid; gap:12px;">
                        <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); cursor:pointer; transition:border-color .2s;" class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked style="accent-color:var(--accent);">
                            <div>
                                <div style="font-size:14px; font-weight:500;">Cash on Delivery</div>
                                <div style="font-size:12px; color:var(--muted);">Pay when your order arrives</div>
                            </div>
                        </label>
                        <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); cursor:pointer; transition:border-color .2s;" class="payment-option">
                            <input type="radio" name="payment_method" value="bank_transfer" style="accent-color:var(--accent);">
                            <div>
                                <div style="font-size:14px; font-weight:500;">Bank Transfer</div>
                                <div style="font-size:12px; color:var(--muted);">Transfer to our account before shipping</div>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Notes --}}
                <div class="form-group">
                    <label class="form-label" for="notes">Order Notes (optional)</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Special instructions, delivery notes...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn btn-dark" style="width:100%; justify-content:center; padding:18px; font-size:12px;">
                    Place Order — ${{ number_format($total, 2) }}
                </button>
            </form>
        </div>

        {{-- Order Summary --}}
        <div style="position:sticky; top:88px;">
            <div style="background:var(--warm); padding:28px; border:1px solid var(--border);">
                <h2 class="serif" style="font-size:22px; margin-bottom:20px;">Order Summary</h2>

                <div style="display:grid; gap:16px; margin-bottom:20px;">
                    @foreach($items as $item)
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:52px; height:64px; background:white; flex-shrink:0; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative;">
                            <span style="position:absolute; top:-4px; right:-4px; background:var(--ink); color:white; border-radius:50%; width:18px; height:18px; font-size:10px; display:flex; align-items:center; justify-content:center;">{{ $item['quantity'] }}</span>
                            <span style="font-size:8px; color:var(--stone); text-align:center; padding:4px;">{{ Str::limit($item['name'], 12) }}</span>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-size:13px; font-family:'Cormorant Garamond',serif; font-size:16px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item['name'] }}</div>
                            @if($item['size'])<div style="font-size:11px; color:var(--muted);">{{ $item['size'] }}</div>@endif
                        </div>
                        <div style="font-size:13px; font-weight:500; white-space:nowrap;">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                    </div>
                    @endforeach
                </div>

                <div style="border-top:1px solid var(--border); padding-top:16px; display:grid; gap:10px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--muted);">Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--muted);">Shipping</span>
                        <span>@if($shipping == 0)<span style="color:var(--success)">Free</span>@else ${{ number_format($shipping, 2) }}@endif</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding-top:10px; border-top:1px solid var(--border); font-size:17px; font-family:'Cormorant Garamond',serif;">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" style="display:block; text-align:center; margin-top:16px; font-size:12px; color:var(--muted); letter-spacing:.08em;">
                ← Edit Bag
            </a>
        </div>

    </div>
</div>

@endsection
