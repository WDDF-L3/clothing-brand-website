@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div style="padding: 48px 0;" class="container">

    {{-- Breadcrumb --}}
    <nav style="font-size:11px; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-bottom:40px;">
        <a href="{{ route('home') }}">Home</a>
        <span style="margin:0 8px;">›</span>
        <a href="{{ route('shop') }}">Shop</a>
        <span style="margin:0 8px;">›</span>
        <a href="{{ route('products.category', $product->category) }}">{{ $product->category->name }}</a>
        <span style="margin:0 8px;">›</span>
        <span style="color:var(--ink);">{{ $product->name }}</span>
    </nav>

    <div style="display:grid; grid-template-columns:1fr 480px; gap:64px; align-items:start;">

        {{-- Images --}}
        <div style="background:var(--warm); aspect-ratio:3/4; display:flex; align-items:center; justify-content:center;">
            @if(!empty($product->images))
                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="text-align:center; color:var(--stone);">
                    <p class="serif" style="font-size:32px; margin-bottom:8px;">{{ $product->name }}</p>
                    <p style="font-size:11px; letter-spacing:.15em; text-transform:uppercase;">No image available</p>
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div style="position:sticky; top:88px;">

            <p style="font-size:10px; letter-spacing:.22em; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">
                {{ $product->category->name }}
            </p>

            <h1 class="serif" style="font-size:42px; font-weight:300; margin-bottom:20px; line-height:1.1;">
                {{ $product->name }}
            </h1>

            {{-- Price --}}
            <div style="display:flex; align-items:baseline; gap:12px; margin-bottom:28px;">
                <span style="font-size:22px; font-weight:500;">{{ $product->formatted_price }}</span>
                @if($product->compare_price)
                <span style="font-size:16px; text-decoration:line-through; color:var(--stone);">{{ $product->formatted_compare_price }}</span>
                <span style="background:var(--accent); color:white; font-size:10px; padding:2px 8px; letter-spacing:.08em; text-transform:uppercase;">
                    Save {{ $product->discount_percent }}%
                </span>
                @endif
            </div>

            <p style="color:var(--muted); line-height:1.8; margin-bottom:32px; font-size:14px;">
                {{ $product->description }}
            </p>

            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf

                @if(!empty($product->sizes))
                <div class="form-group">
                    <label class="form-label">Size</label>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        @foreach($product->sizes as $size)
                        <label style="cursor:pointer;">
                            <input type="radio" name="size" value="{{ $size }}" style="display:none;" class="size-radio" required>
                            <span class="size-chip" style="display:inline-flex; align-items:center; justify-content:center; width:48px; height:48px; border:1px solid var(--border); font-size:12px; letter-spacing:.05em; transition:all .2s; cursor:pointer;">
                                {{ $size }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($product->colors))
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select name="color" class="form-control">
                        @foreach($product->colors as $color)
                        <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ min(10, $product->stock) }}" class="form-control" style="width:100px;">
                </div>

                <button type="submit" class="btn btn-dark" style="width:100%; justify-content:center; padding:16px;">
                    Add to Bag — {{ $product->formatted_price }}
                </button>
            </form>
            @else
            <div style="padding:16px; background:var(--warm); text-align:center; border:1px solid var(--border); font-size:12px; letter-spacing:.1em; text-transform:uppercase; color:var(--muted);">
                Currently Out of Stock
            </div>
            @endif

            {{-- Stock --}}
            <p style="font-size:12px; color:var(--muted); margin-top:16px; text-align:center;">
                @if($product->stock <= 3 && $product->stock > 0)
                    ⚠ Only {{ $product->stock }} left in stock
                @elseif($product->stock > 3)
                    ✓ In stock ({{ $product->stock }} available)
                @endif
            </p>

            {{-- Meta --}}
            <div style="border-top:1px solid var(--border); margin-top:32px; padding-top:24px; font-size:12px; color:var(--muted); display:grid; gap:8px;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="letter-spacing:.1em; text-transform:uppercase;">Free Shipping</span>
                    <span>on orders over $100</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="letter-spacing:.1em; text-transform:uppercase;">Returns</span>
                    <span>30-day free returns</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->isNotEmpty())
    <div style="margin-top:80px;">
        <h2 class="serif" style="font-size:32px; margin-bottom:32px; text-align:center;">You may also like</h2>
        <div class="product-grid">
            @foreach($related as $relProduct)
            @include('components.product-card', ['product' => $relProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
.size-radio:checked + .size-chip {
    background: var(--ink);
    color: var(--cream);
    border-color: var(--ink);
}
.size-chip:hover {
    border-color: var(--ink);
}
</style>
@endpush

@endsection
