<x-app-layout>
    <x-slot name="header">Order Details</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Order #{{ $order->order_number }}</div>
            <div class="page-hdr-sub">Created {{ $order->created_at->diffForHumans() }} by {{ $order->user->name ?? 'N/A' }}</div>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to Orders
        </a>
    </div>

    {{-- Order Info Card --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Order Information</span>
            @php
                $sc = match($order->status) {
                    'completed' => 'badge-success', 'cancelled' => 'badge-danger',
                    'pending'   => 'badge-warning',  default => 'badge-gray',
                };
            @endphp
            <span class="badge {{ $sc }}" style="font-size:0.78rem;padding:0.3rem 0.8rem;">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="card-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-key">Order Number</div>
                    <div class="detail-value" style="color:#6366f1;">{{ $order->order_number }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-key">Order Date</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-key">Expected Delivery</div>
                    <div class="detail-value">{{ $order->expected_delivery ? \Carbon\Carbon::parse($order->expected_delivery)->format('d M Y') : 'Not specified' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-key">Supplier</div>
                    <div class="detail-value" style="font-weight:700;">{{ $order->supplier->name ?? 'N/A' }}</div>
                    @if($order->supplier)
                        <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $order->supplier->phone }} · {{ $order->supplier->email }}</div>
                    @endif
                </div>
                <div class="detail-item">
                    <div class="detail-key">Created By</div>
                    <div class="detail-value">{{ $order->user->name ?? 'N/A' }}</div>
                </div>
                @if($order->notes)
                <div class="detail-item" style="grid-column:1/-1;">
                    <div class="detail-key">Notes</div>
                    <div class="detail-value" style="font-weight:400;font-size:0.9rem;color:var(--text-secondary);">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Order Items Table --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Order Items</span>
            @if($order->total_amount)
                <span style="font-size:0.9rem;font-weight:700;color:#6366f1;">Total: {{ number_format($order->total_amount, 2) }} FCFA</span>
            @endif
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Ordered Qty</th>
                        <th>Unit Price</th>
                        <th>Received Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $line)
                    <tr>
                        <td><span style="font-weight:600;">{{ $line->item->name }}</span></td>
                        <td>{{ $line->quantity_ordered }}</td>
                        <td>{{ number_format($line->unit_price, 2) }} FCFA</td>
                        <td>
                            @if($line->quantity_received >= $line->quantity_ordered)
                                <span class="badge badge-success">{{ $line->quantity_received }} ✓</span>
                            @else
                                <span style="font-weight:600;">{{ $line->quantity_received }} / {{ $line->quantity_ordered }}</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <span class="amount">{{ number_format($line->quantity_ordered * $line->unit_price, 2) }} FCFA</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:2rem;">No items in this order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Actions --}}
    @if($order->status !== 'completed' && $order->status !== 'cancelled')
    <div style="display:flex;gap:0.75rem;">
        <form action="{{ route('orders.update', $order) }}" method="POST"
              onsubmit="return confirm('Complete this order? Stock will be updated.')">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="btn btn-success">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Mark as Completed
            </button>
        </form>
    </div>
    @endif

</x-app-layout>
