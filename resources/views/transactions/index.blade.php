<x-app-layout>
    <x-slot name="header">Transactions</x-slot>
    @include('components.page-styles')

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Inventory Transactions</div>
            <div class="page-hdr-sub">All stock movements — inbound, outbound, and adjustments</div>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Log Transaction
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Transaction Log ({{ $transactions->count() }})</span>
            <div class="search-bar" style="width:220px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" placeholder="Search..." oninput="filterTable(this,'txTable')">
            </div>
        </div>

        @if($transactions->count())
        <div style="overflow-x:auto;">
            <table class="data-table" id="txTable">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Qty Change</th>
                        <th>By</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $tx)
                    <tr>
                        <td style="color:var(--text-secondary);font-size:0.8rem;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}<br>
                            <span style="font-size:0.72rem;">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('H:i') }}</span>
                        </td>
                        <td><span style="font-weight:600;">{{ $tx->item->name }}</span></td>
                        <td>
                            @php
                                $tc = match(strtoupper($tx->type)) {
                                    'IN'         => ['badge-success', '↑ IN'],
                                    'OUT'        => ['badge-danger',  '↓ OUT'],
                                    'ADJUSTMENT' => ['badge-info',    '~ ADJ'],
                                    default      => ['badge-gray',    $tx->type],
                                };
                            @endphp
                            <span class="badge {{ $tc[0] }}">{{ $tc[1] }}</span>
                        </td>
                        <td>
                            <span class="amount {{ $tx->quantity_change > 0 ? 'amount-positive' : 'amount-negative' }}"
                                  style="font-size:1rem;">
                                {{ $tx->quantity_change > 0 ? '+' : '' }}{{ $tx->quantity_change }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.4rem;">
                                <div class="avatar" style="width:24px;height:24px;font-size:0.6rem;">
                                    {{ strtoupper(substr($tx->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size:0.82rem;">{{ $tx->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td style="color:var(--text-secondary);font-size:0.8rem;">{{ $tx->reference ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="1.5"/><path d="M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4" stroke="currentColor" stroke-width="1.5"/></svg>
                <h3>No transactions yet</h3>
                <p>Log your first stock movement to start tracking inventory.</p>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">Log Transaction</a>
            </div>
        @endif
    </div>

    <script>
        function filterTable(input, tableId) {
            const q = input.value.toLowerCase();
            document.querySelectorAll('#' + tableId + ' tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
