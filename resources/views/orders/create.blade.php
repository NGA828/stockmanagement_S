<x-app-layout>
    <x-slot name="header">Create Order</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Create Purchase Order</div>
            <div class="page-hdr-sub">Select items and quantities to place a new order</div>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to Orders
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" style="display:inline;margin-right:0.4rem;vertical-align:middle;"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="#6366f1" stroke-width="2"/></svg>
                    Item Selection
                </span>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Enter 0 to exclude an item</span>
            </div>
            <div class="card-body" style="padding-top:0.75rem;padding-bottom:0.75rem;">
                @foreach($items as $index => $item)
                <div class="order-item-row">
                    <div>
                        <div class="order-item-name">{{ $item->name }}</div>
                        <div class="order-item-price">
                            {{ number_format($item->price, 2) }} FCFA &nbsp;·&nbsp;
                            Current stock: <strong>{{ $item->quantity }}</strong>
                            @if($item->quantity < 10)
                                <span class="badge badge-warning" style="margin-left:0.3rem;">Low</span>
                            @endif
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                        <input type="number"
                               name="items[{{ $index }}][quantity]"
                               class="form-control order-qty-input"
                               min="0" value="0"
                               placeholder="Qty">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card" style="max-width:560px;">
            <div class="card-header"><span class="card-title">Order Notes</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="notes">Notes / Reference</label>
                    <textarea id="notes" name="notes" class="form-control"
                              placeholder="Optional notes, supplier info, reference number...">{{ old('notes') }}</textarea>
                </div>

                <div class="form-footer">
                    <a href="{{ route('orders.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"/><path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
