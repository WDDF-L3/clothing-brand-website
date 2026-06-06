@extends('layouts.app')

@section('title', $category->name)

@section('content')

<div style="padding: 48px 0;" class="container">

    <div style="margin-bottom:40px;">
        <p style="font-size:10px; letter-spacing:.22em; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">
            <a href="{{ route('shop') }}">Shop</a> ›
        </p>
        <h1 class="serif" style="font-size:48px; font-weight:300;">{{ $category->name }}</h1>
        @if($category->description)
        <p style="color:var(--muted); margin-top:8px;">{{ $category->description }}</p>
        @endif
    </div>

    @if($products->isEmpty())
    <div style="text-align:center; padding:80px 0; color:var(--muted);">
        <p class="serif" style="font-size:32px;">No products in this category yet.</p>
        <a href="{{ route('shop') }}" class="btn btn-outline" style="margin-top:24px; display:inline-flex;">Browse All</a>
    </div>
    @else
    <div class="product-grid">
        @foreach($products as $product)
        @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
    <div style="margin-top:48px; display:flex; justify-content:center;">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
