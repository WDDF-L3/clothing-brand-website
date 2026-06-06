@extends('admin.layout')
@section('title', 'Products')

@section('topbar-actions')
<a href="{{ route('admin.products.create') }}" class="btn btn-accent">+ New Product</a>
@endsection

@section('content')

{{-- Filters --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:14px 20px;">
        <form action="{{ route('admin.products.index') }}" method="GET" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <input type="text" name="search" placeholder="Search products…" class="form-control" style="width:220px;" value="{{ request('search') }}">
            <select name="category" class="form-control" style="width:160px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">Filter</button>
            @if(request('search') || request('category'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Clear</a>
            @endif
            <span style="margin-left:auto; font-size:12px; color:var(--muted);">{{ $products->total() }} products</span>
        </form>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="product-thumb">
                            @if(!empty($product->images))
                                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}">
                            @else
                                <div class="product-thumb-text">No img</div>
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:13px;">{{ $product->name }}</div>
                            <div style="font-size:11px; color:var(--muted);">{{ $product->slug }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-muted">{{ $product->category->name ?? '—' }}</span></td>
                <td>
                    <div style="font-weight:600;">Tk{{ number_format($product->price, 2) }}</div>
                    @if($product->compare_price)
                    <div style="font-size:11px; color:var(--muted); text-decoration:line-through;">Tk{{ number_format($product->compare_price, 2) }}</div>
                    @endif
                </td>
                <td>
                    @if($product->stock === 0)
                        <span class="badge badge-red">Out of stock</span>
                    @elseif($product->stock <= 5)
                        <span class="badge badge-yellow">{{ $product->stock }} left</span>
                    @else
                        <span style="font-size:13px;">{{ $product->stock }}</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.products.toggle-active', $product) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="badge {{ $product->is_active ? 'badge-green' : 'badge-red' }}" style="cursor:pointer; border:none; background:inherit;">
                            {{ $product->is_active ? 'Active' : 'Hidden' }}
                        </button>
                    </form>
                </td>
                <td>
                    @if($product->is_featured)
                    <span class="badge badge-accent">⭐ Featured</span>
                    @else
                    <span style="color:var(--muted); font-size:12px;">—</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete \'{{ addslashes($product->name) }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:40px; color:var(--muted);">
                    No products found. <a href="{{ route('admin.products.create') }}" style="color:var(--accent);">Add one →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->hasPages())
    <div style="padding:16px 20px; border-top:1px solid var(--border);">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
