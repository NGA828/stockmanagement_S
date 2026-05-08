<x-app-layout>
    <x-slot name="header">Dispatch Details</x-slot>
    @include('components.page-styles')

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Order #{{ $dispatch->dispatch_number }}</div>
            <div class="page-hdr-sub">Manage dispatch status and finalize shipment</div>
        </div>
        <a href="{{ route('dispatches.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to List
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:1.5rem;align-items:start;">
        
        {{-- Left: Details & Items --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><span class="card-title">General Information</span></div>
                <div class="card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Recipient / Client</div>
                        <div style="font-weight:700;color:var(--text-primary);">{{ $dispatch->client->name }}</div>
                        <div style="font-size:0.875rem;color:var(--text-secondary);margin-top:0.25rem;">
                            {{ $dispatch->client->contact_person }}<br>
                            {{ $dispatch->client->email }}<br>
                            {{ $dispatch->client->phone }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Dispatch Timeline</div>
                        <div style="font-size:0.875rem;color:var(--text-primary);">
                            <strong>Created:</strong> {{ $dispatch->created_at->format('M d, Y') }}<br>
                            <strong>Scheduled:</strong> {{ $dispatch->dispatch_date->format('M d, Y') }}<br>
                            <strong>By:</strong> {{ $dispatch->user->name }}
                        </div>
                    </div>
                </div>
                @if($dispatch->notes)
                <div class="card-body" style="border-top:1px solid var(--header-border);background:var(--main-bg);">
                    <div style="font-size:0.75rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Notes</div>
                    <div style="font-size:0.875rem;color:var(--text-primary);">{{ $dispatch->notes }}</div>
                </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title">Items List</span></div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th style="text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($dispatch->dispatchItems as $dItem)
                                @php $subtotal = $dItem->quantity * $dItem->unit_price; $total += $subtotal; @endphp
                                <tr>
                                    <td style="font-weight:600;">{{ $dItem->item->name }}</td>
                                    <td>{{ $dItem->quantity }}</td>
                                    <td>{{ number_format($dItem->unit_price, 0, '.', ' ') }} FCFA</td>
                                    <td style="text-align:right;font-weight:700;">{{ number_format($subtotal, 0, '.', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:var(--main-bg);">
                                <td colspan="3" style="text-align:right;font-weight:700;">Total Value:</td>
                                <td style="text-align:right;font-weight:800;color:var(--accent);font-size:1.1rem;">{{ number_format($total, 0, '.', ' ') }} FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Status & Actions --}}
        <div class="card" style="position:sticky;top:1.5rem;">
            <div class="card-header"><span class="card-title">Dispatch Status</span></div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
                    @php
                        $statusClass = [
                            'draft' => 'badge-info',
                            'pending' => 'badge-warning',
                            'shipped' => 'badge-success',
                            'cancelled' => 'badge-danger'
                        ][$dispatch->status] ?? 'badge-info';
                    @endphp
                    <span class="badge {{ $statusClass }}" style="font-size:0.9rem;padding:0.4rem 0.8rem;text-transform:uppercase;">{{ $dispatch->status }}</span>
                </div>

                @if($dispatch->status === 'draft')
                    <form action="{{ route('dispatches.update', $dispatch) }}" method="POST" style="display:flex;flex-direction:column;gap:0.75rem;">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="shipped">
                        <button type="submit" class="btn btn-primary" style="width:100%;" onclick="return confirm('Confirm shipping? This will deduct items from stock.')">
                            Finalize & Ship
                        </button>
                    </form>
                    <form action="{{ route('dispatches.update', $dispatch) }}" method="POST" style="margin-top:0.5rem;">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-ghost" style="width:100%;color:#ef4444;" onclick="return confirm('Cancel this dispatch?')">
                            Cancel Dispatch
                        </button>
                    </form>
                @elseif($dispatch->status === 'shipped')
                    <div class="alert alert-success" style="margin-bottom:0;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Stock has been deducted.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
