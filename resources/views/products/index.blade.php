@extends('layouts.app')

@section('title', 'Shop')

@section('content')

{{-- Hero (only on homepage) --}}
@if(request()->routeIs('home') && $featured->isNotEmpty())
<section style="background:var(--ink); color:var(--cream); padding: 80px 0; overflow:hidden; position:relative;">
    <div class="container" style="display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;">
        <div>
            <p style="font-size:11px; letter-spacing:.25em; text-transform:uppercase; color:var(--stone); margin-bottom:16px;">New Collection</p>
            <h1 class="serif" style="font-size:clamp(48px,6vw,80px); line-height:1; margin-bottom:24px; font-weight:300;">
                Dressed<br><em>to endure.</em>
            </h1>
            <p style="color:var(--stone); line-height:1.8; margin-bottom:36px; max-width:380px;">
                Timeless pieces crafted from the finest materials. Each garment designed to become a cornerstone of your wardrobe.
            </p>
            <a href="{{ route('shop') }}" class="btn btn-accent">Shop the Collection</a>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:4px;">
            @foreach($featured->take(4) as $p)
            <a href="{{ route('products.show', $p) }}" style="aspect-ratio:3/4; overflow:hidden; background:var(--warm); display:block;">
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:13px;color:#7a736b;text-align:center;padding:12px;">{{ $p->name }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section style="padding: 48px 0;">
    <div class="container">

        {{-- Toolbar --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
            <div>
                <h2 class="serif" style="font-size:28px;">
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @else
                        All Products
                    @endif
                </h2>
                <p style="font-size:12px; color:var(--muted); margin-top:4px;">{{ $products->total() }} pieces</p>
            </div>

            <form action="{{ route('shop') }}" method="GET" style="display:flex; align-items:center; gap:8px;">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                <select name="sort" onchange="this.form.submit()" class="form-control" style="width:auto; font-size:12px; padding:8px 12px;">
                    <option value="newest"     {{ request('sort','newest') === 'newest'     ? 'selected':'' }}>Newest</option>
                    <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected':'' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected':'' }}>Price: High → Low</option>
                    <option value="name"       {{ request('sort') === 'name'                ? 'selected':'' }}>Name A–Z</option>
                </select>
            </form>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div style="text-align:center; padding:80px 0; color:var(--muted);">
            <p class="serif" style="font-size:32px; margin-bottom:12px;">No products found.</p>
            <a href="{{ route('shop') }}" class="btn btn-outline" style="margin-top:16px;">Browse All</a>
        </div>
        @else
        <div class="product-grid">
            @foreach($products as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="margin-top:48px; display:flex; justify-content:center;">
            {{ $products->links() }}
        </div>
        @endif

    </div>
</section>

@endsection
