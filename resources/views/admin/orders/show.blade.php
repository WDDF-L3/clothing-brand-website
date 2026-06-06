@extends('admin.layout')
@section('title', 'Order ' . $order->order_number)

@section('topbar-actions')
<a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">← Back to Orders</a>
@endsection

@section('content')

<div style="display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

    {{-- Left --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Items --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Order Items</span></div>
            <table class="table">
                <thead>
                    <tr><th>Product</th><th>Variant</th><th>Qty</th><th>Unit</th><th>Total</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="font-weight:600;">{{ $item->product_name }}</td>
                        <td style="color:var(--muted); font-size:12px;">
                            @if($item->size) Size: {{ $item->size }} @endif
                            @if($item->color) · {{ $item->color }} @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td style="font-weight:600;">${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:16px 20px; border-top:1px solid var(--border);">
                <div style="display:flex; flex-direction:column; gap:8px; max-width:240px; margin-left:auto; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; color:var(--muted);">
                        <span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; color:var(--muted);">
                        <span>Shipping</span><span>{{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost,2) : 'Free' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:16px; font-weight:700; padding-top:8px; border-top:1px solid var(--border);">
                        <span>Total</span><span style="color:var(--accent);">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Shipping Address</span></div>
            <div class="card-body" style="font-size:14px; line-height:2;">
                <strong>{{ $order->customer_name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                {{ $order->shipping_country }}
            </div>
        </div>

        @if($order->notes)
        <div class="card">
            <div class="card-header"><span class="card-title">Customer Notes</span></div>
            <div class="card-body" style="color:var(--muted); font-size:13px;">{{ $order->notes }}</div>
        </div>
        @endif
    </div>

    {{-- Right --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Status --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Update Status</span></div>
            <div class="card-body">
                @php $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'accent','delivered'=>'green','cancelled'=>'red']; @endphp
                <div style="margin-bottom:16px;">
                    <span class="badge badge-{{ $colors[$order->status] ?? 'muted' }}" style="font-size:12px; padding:4px 12px;">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-control" style="margin-bottom:12px;">
                        @foreach(\App\Models\Order::STATUSES as $val => $label)
                        <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-accent" style="width:100%;">Update Status</button>
                </form>
            </div>
        </div>

        {{-- Customer --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Customer</span></div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:10px; font-size:13px;">
                <div><span style="color:var(--muted);">Name</span><br><strong>{{ $order->customer_name }}</strong></div>
                <div><span style="color:var(--muted);">Email</span><br>{{ $order->customer_email }}</div>
                <div><span style="color:var(--muted);">Phone</span><br>{{ $order->customer_phone }}</div>
                <div><span style="color:var(--muted);">Payment</span><br>
                    <span class="badge badge-muted">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div><span style="color:var(--muted);">Order Date</span><br>{{ $order->created_at->format('M d, Y · H:i') }}</div>
            </div>
        </div>

        {{-- Delete --}}
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Permanently delete this order?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%;">Delete Order</button>
        </form>
    </div>
</div>

@endsection
