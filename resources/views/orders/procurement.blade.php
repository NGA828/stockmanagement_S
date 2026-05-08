<x-app-layout>
    <x-slot name="header">Procurement Center</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Stock Procurement</div>
            <div class="page-hdr-sub">Items currently below reorder levels</div>
        </div>
    </div>

    @if($lowStockItems->count())
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 350px;gap:1.5rem;align-items:start;">
            
            <div class="card">
                <div class="card-header"><span class="card-title">Low Stock Items</span></div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:40px;"><input type="checkbox" id="selectAll" checked onclick="toggleAll(this)"></th>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Reorder Level</th>
                                <th style="width:150px;">Order Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockItems as $index => $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="items[{{ $index }}][selected]" value="1" checked class="item-checkbox">
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                </td>
                                <td>
                                    <div style="font-weight:600;color:var(--text-primary);">{{ $item->name }}</div>
                                    <div style="font-size:0.75rem;color:var(--text-secondary);">SKU: {{ $item->sku }}</div>
                                </td>
                                <td>{{ $item->category->name }}</td>
                                <td>
                                    <span style="color:#ef4444;font-weight:700;">{{ $item->quantity }}</span>
                                </td>
                                <td>{{ $item->reorder_level ?? 10 }}</td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ ($item->reorder_level ?? 10) * 2 }}" min="1">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                function toggleAll(source) {
                    const checkboxes = document.querySelectorAll('.item-checkbox');
                    for(const checkbox of checkboxes) {
                        checkbox.checked = source.checked;
                    }
                }
            </script>

            <div class="card" style="position:sticky;top:1.5rem;">
                <div class="card-header"><span class="card-title">Generate Order</span></div>
                <div class="card-body">
                    <p style="font-size:0.875rem;color:var(--text-secondary);margin-bottom:1.25rem;">
                        Select a supplier to create a bulk purchase order for the items listed.
                    </p>
                    
                    <div class="form-group">
                        <label class="form-label">Select Supplier <span class="req">*</span></label>
                        <select name="supplier_id" class="form-control" required>
                            <option value="">Choose Supplier...</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="e.g. Urgent restock"></textarea>
                    </div>

                    <div class="form-footer" style="flex-direction:column;gap:0.75rem;">
                        <button type="submit" class="btn btn-primary" style="width:100%;">Create Purchase Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
        <div class="empty-state">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <h3>All stock levels are healthy</h3>
            <p>No items currently require reordering based on your defined levels.</p>
        </div>
    @endif
</x-app-layout>
