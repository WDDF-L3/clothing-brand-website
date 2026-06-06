@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value stat-accent">Tk{{ number_format($stats['total_revenue'], 0) }}</div>
        <div class="stat-sub">From completed orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-sub"><span class="stat-yellow">{{ $stats['pending_orders'] }} pending</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Products</div>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-sub">{{ $stats['active_products'] }} active</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock Alerts</div>
        <div class="stat-value stat-red">{{ $stats['out_of_stock'] }}</div>
        <div class="stat-sub">{{ $stats['low_stock'] }} low stock</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Recent Orders</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" style="color:var(--accent); font-family:'DM Mono',monospace; font-size:12px;">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td>{{ $order->customer_name }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        @php
                            $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'accent','delivered'=>'green','cancelled'=>'red'];
                            $c = $colors[$order->status] ?? 'muted';
                        @endphp
                        <span class="badge badge-{{ $c }}">{{ $order->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="color:var(--muted); text-align:center;">No orders yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Low Stock --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">⚠ Low Stock Items</span>
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">Manage</a>
        </div>
        <table class="table">
            <thead>
                <tr><th>Product</th><th>Stock</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($low_stock_items as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>
                        <span class="badge {{ $p->stock === 0 ? 'badge-red' : 'badge-yellow' }}">
                            {{ $p->stock === 0 ? 'Out of stock' : $p->stock . ' left' }}
                        </span>
                    </td>
                    <td><a href="{{ route('admin.products.edit', $p) }}" class="btn btn-ghost btn-sm">Edit</a></td>
                </tr>
                @empty
                <tr><td colspan="3" style="color:var(--muted); text-align:center;">All items well stocked ✓</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Quick links --}}
<div style="display:flex; gap:12px; margin-top:20px;">
    <a href="{{ route('admin.products.create') }}" class="btn btn-accent">+ Add Product</a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Manage Categories</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">View All Orders</a>
</div>

@endsection
