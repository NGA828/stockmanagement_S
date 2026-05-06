<x-app-layout>
    <x-slot name="header">Orders</x-slot>
    @include('components.page-styles')

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Purchase Orders</div>
            <div class="page-hdr-sub">Track and manage all incoming stock orders</div>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            New Order
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Orders ({{ $orders->count() }})</span>
        </div>

        @if($orders->count())
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Created By</th>
                        <th>Total</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            <span style="font-weight:700;color:#6366f1;font-size:0.9rem;">{{ $order->order_number }}</span>
                        </td>
                        <td>
                            @php
                                $sc = match($order->status) {
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    'pending'   => 'badge-warning',
                                    default     => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $sc }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td style="color:var(--text-secondary);">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <div class="avatar" style="width:26px;height:26px;font-size:0.65rem;">
                                    {{ strtoupper(substr($order->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size:0.83rem;">{{ $order->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td><span class="amount">{{ number_format($order->total_amount ?? 0, 2) }} FCFA</span></td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-ghost btn-sm">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                                    View
                                </a>
                                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                    <form action="{{ route('orders.update', $order) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Mark this order as completed? Stock levels will be updated.')">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                            Complete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="1.5"/><line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="1.5"/></svg>
                <h3>No orders yet</h3>
                <p>Create your first purchase order to start tracking stock.</p>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">New Order</a>
            </div>
        @endif
    </div>
</x-app-layout>
