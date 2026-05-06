<x-app-layout>
    <x-slot name="header">Log Transaction</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Log Transaction</div>
            <div class="page-hdr-sub">Record stock movements — IN, OUT, or Adjustment</div>
        </div>
        <a href="{{ route('transactions.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    {{-- Type selector (visual radio buttons) --}}
    <div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <label style="flex:1;min-width:130px;cursor:pointer;">
            <input type="radio" name="__type_display" value="IN" style="display:none;" onclick="setType('IN')" checked>
            <div class="type-card" id="card-IN" style="border:2px solid #10b981;background:rgba(16,185,129,0.08);border-radius:12px;padding:1rem 1.2rem;text-align:center;transition:all 0.18s;">
                <div style="font-size:1.4rem;margin-bottom:0.3rem;">↑</div>
                <div style="font-weight:700;color:#059669;font-size:0.9rem;">Stock IN</div>
                <div style="font-size:0.73rem;color:var(--text-secondary);margin-top:2px;">Receive goods</div>
            </div>
        </label>
        <label style="flex:1;min-width:130px;cursor:pointer;">
            <input type="radio" name="__type_display" value="OUT" style="display:none;" onclick="setType('OUT')">
            <div class="type-card" id="card-OUT" style="border:2px solid var(--header-border);border-radius:12px;padding:1rem 1.2rem;text-align:center;transition:all 0.18s;">
                <div style="font-size:1.4rem;margin-bottom:0.3rem;">↓</div>
                <div style="font-weight:700;color:#dc2626;font-size:0.9rem;">Stock OUT</div>
                <div style="font-size:0.73rem;color:var(--text-secondary);margin-top:2px;">Issue / dispatch</div>
            </div>
        </label>
        @if(in_array(Auth::user()->role, ['admin', 'stock_manager']))
        <label style="flex:1;min-width:130px;cursor:pointer;">
            <input type="radio" name="__type_display" value="ADJUSTMENT" style="display:none;" onclick="setType('ADJUSTMENT')">
            <div class="type-card" id="card-ADJUSTMENT" style="border:2px solid var(--header-border);border-radius:12px;padding:1rem 1.2rem;text-align:center;transition:all 0.18s;">
                <div style="font-size:1.4rem;margin-bottom:0.3rem;">~</div>
                <div style="font-weight:700;color:#6366f1;font-size:0.9rem;">Adjustment</div>
                <div style="font-size:0.73rem;color:var(--text-secondary);margin-top:2px;">Correct count</div>
            </div>
        </label>
        @endif
    </div>

    <div class="card" style="max-width:680px;">
        <div class="card-header"><span class="card-title">Transaction Details</span></div>
        <div class="card-body">
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                <input type="hidden" name="type" id="typeInput" value="IN">

                <div class="form-grid form-grid-2" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="item_id">Select Item <span class="req">*</span></label>
                        <select name="item_id" id="item_id" class="form-control" required>
                            <option value="">— Choose item —</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} &nbsp;(Stock: {{ $item->quantity }})
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity_change">Quantity <span class="req">*</span></label>
                        <input id="quantity_change" name="quantity_change" type="number"
                               class="form-control" placeholder="Enter amount"
                               value="{{ old('quantity_change') }}" required>
                        <p class="form-hint" id="qtyHint">For IN: enter units received. System will add to stock.</p>
                        @error('quantity_change')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reference">Reference</label>
                        <input id="reference" name="reference" type="text" class="form-control"
                               value="{{ old('reference') }}" placeholder="e.g. PO-001, Invoice #123">
                        @error('reference')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="transaction_date">Date</label>
                        <input id="transaction_date" name="transaction_date" type="datetime-local"
                               class="form-control" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="form-control"
                              placeholder="Optional additional notes...">{{ old('notes') }}</textarea>
                </div>

                <div class="form-footer">
                    <a href="{{ route('transactions.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Log Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const hints = {
            IN:         'Enter units received — will be added to current stock.',
            OUT:        'Enter units dispatched — will be deducted from stock.',
            ADJUSTMENT: 'Enter a positive or negative number to correct the stock count.',
        };
        const colors = {
            IN:         '2px solid #10b981',
            OUT:        '2px solid #ef4444',
            ADJUSTMENT: '2px solid #6366f1',
        };
        const bg = {
            IN:         'rgba(16,185,129,0.08)',
            OUT:        'rgba(239,68,68,0.08)',
            ADJUSTMENT: 'rgba(99,102,241,0.08)',
        };

        function setType(type) {
            document.getElementById('typeInput').value = type;
            document.getElementById('qtyHint').textContent = hints[type];
            ['IN','OUT','ADJUSTMENT'].forEach(t => {
                const card = document.getElementById('card-' + t);
                if (!card) return;
                card.style.border = t === type ? colors[t] : '2px solid var(--header-border)';
                card.style.background = t === type ? bg[t] : 'transparent';
            });
        }
    </script>
</x-app-layout>
