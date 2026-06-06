@extends('admin.layout')
@section('title', 'Orders')

@section('content')

{{-- Status filter --}}
<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    @php $statuses = [''=>'All', 'pending'=>'Pending', 'processing'=>'Processing', 'shipped'=>'Shipped', 'delivered'=>'Delivered', 'cancelled'=>'Cancelled']; @endphp
    @foreach($statuses as $val => $label)
    <a href="{{ route('admin.orders.index', $val ? ['status'=>$val] : []) }}"
       class="btn {{ request('status') == $val ? 'btn-accent' : 'btn-ghost' }} btn-sm">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" style="color:var(--accent); font-size:12px; font-weight:600;">
                        {{ $order->order_number }}
                    </a>
                </td>
                <td>
                    <div style="font-weight:600; font-size:13px;">{{ $order->customer_name }}</div>
                    <div style="font-size:11px; color:var(--muted);">{{ $order->customer_email }}</div>
                </td>
                <td style="color:var(--muted);">{{ $order->items()->count() }}</td>
                <td style="font-weight:600;">${{ number_format($order->total, 2) }}</td>
                <td><span class="badge badge-muted">{{ strtoupper($order->payment_method) }}</span></td>
                <td style="font-size:12px; color:var(--muted);">{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    @php $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'accent','delivered'=>'green','cancelled'=>'red']; @endphp
                    <span class="badge badge-{{ $colors[$order->status] ?? 'muted' }}">{{ $order->status }}</span>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm">View</a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this order?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:var(--muted);">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($orders->hasPages())
    <div style="padding:16px 20px; border-top:1px solid var(--border);">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
