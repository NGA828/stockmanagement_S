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
            <div class="page-hdr-title">Stock Movements</div>
            <div class="page-hdr-sub">Track incoming purchases and outgoing sales</div>
        </div>
    </div>

    {{-- Tab Headers --}}
    <div style="display:flex; gap:1rem; margin-bottom:1.25rem; border-bottom:1px solid var(--header-border);">
        <button onclick="showTab('in')" id="tab-in" class="tab-btn active">Purchase IN (Orders)</button>
        <button onclick="showTab('out')" id="tab-out" class="tab-btn">Purchase OUT (Sales)</button>
    </div>

    {{-- Purchase IN Section --}}
    <div id="section-in" class="tab-section">
        <div class="card">
            <div class="card-header"><span class="card-title">Incoming Orders ({{ $orders->count() }})</span></div>
            @if($orders->count())
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td style="font-weight:700;color:#6366f1;">{{ $order->order_number }}</td>
                            <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                            <td><span class="amount" style="font-weight:700;">{{ number_format($order->total_amount, 0, '.', ' ') }} FCFA</span></td>
                            <td>
                                @php $sc = match($order->status){ 'completed'=>'badge-success', 'cancelled'=>'badge-danger', 'pending'=>'badge-warning', default=>'badge-gray' }; @endphp
                                <span class="badge {{ $sc }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td style="color:var(--text-secondary);">{{ $order->order_date->format('d M Y') }}</td>
                            <td>
                                <div class="actions-cell" style="justify-content:flex-end;">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-ghost btn-sm">View</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="empty-state"><p>No purchase orders found.</p></div>
            @endif
        </div>
    </div>

    {{-- Purchase OUT Section --}}
    <div id="section-out" class="tab-section" style="display:none;">
        <div class="card">
            <div class="card-header"><span class="card-title">Outgoing Sales ({{ $dispatches->count() }})</span></div>
            @if($dispatches->count())
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Dispatch #</th>
                            <th>Client</th>
                            <th>Total Value</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                        <tr>
                            <td style="font-weight:700;color:#10b981;">{{ $dispatch->dispatch_number }}</td>
                            <td>{{ $dispatch->client->name ?? 'N/A' }}</td>
                            <td><span class="amount" style="font-weight:700;">{{ number_format($dispatch->total_amount, 0, '.', ' ') }} FCFA</span></td>
                            <td>
                                @php $sc = match($dispatch->status){ 'shipped'=>'badge-success', 'cancelled'=>'badge-danger', 'pending'=>'badge-warning', 'draft'=>'badge-info', default=>'badge-gray' }; @endphp
                                <span class="badge {{ $sc }}">{{ ucfirst($dispatch->status) }}</span>
                            </td>
                            <td style="color:var(--text-secondary);">{{ $dispatch->dispatch_date->format('d M Y') }}</td>
                            <td>
                                <div class="actions-cell" style="justify-content:flex-end;">
                                    <a href="{{ route('dispatches.show', $dispatch) }}" class="btn btn-ghost btn-sm">View</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="empty-state"><p>No sales dispatches found.</p></div>
            @endif
        </div>
    </div>

    <style>
        .tab-btn {
            padding: 0.75rem 1.25rem; background: none; border: none; font-size: 0.88rem; font-weight: 600;
            color: var(--text-secondary); cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.2s;
        }
        .tab-btn:hover { color: var(--text-primary); }
        .tab-btn.active { color: #6366f1; border-bottom-color: #6366f1; background: rgba(99,102,241,0.05); }
    </style>

    <script>
        function showTab(type) {
            document.querySelectorAll('.tab-section').forEach(s => s.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('section-' + type).style.display = 'block';
            document.getElementById('tab-' + type).classList.add('active');
        }
    </script>
</x-app-layout>
