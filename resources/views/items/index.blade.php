<x-app-layout>
    <x-slot name="header">Items</x-slot>
    @include('components.page-styles')

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Items</div>
            <div class="page-hdr-sub">Manage your inventory items and stock levels</div>
        </div>
        @if(Auth::user()->role !== 'warehouse_staff')
            <a href="{{ route('items.create') }}" class="btn btn-primary">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                Add Item
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Items ({{ $items->count() }})</span>
            <div class="search-bar" style="width:240px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" id="itemSearch" placeholder="Search items..." oninput="filterTable(this,'itemsTable')">
            </div>
        </div>

        @if($items->count())
        <div style="overflow-x:auto;">
            <table class="data-table" id="itemsTable">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        @if(Auth::user()->role !== 'warehouse_staff')
                        <th>Price</th>
                        @endif
                        <th>In Stock</th>
                        <th>Status</th>
                        @if(Auth::user()->role !== 'warehouse_staff')
                        <th style="text-align:right;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.65rem;">
                                <div style="width:34px;height:34px;border-radius:9px;background:rgba(99,102,241,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;border:1px solid #f1f5f9;">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="#6366f1" stroke-width="2"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:600;">{{ $item->name }}</div>
                                    @if($item->sku)
                                        <div style="font-size:0.72rem;color:var(--text-secondary);">SKU: {{ $item->sku }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $item->category->name }}</span>
                        </td>
                        @if(Auth::user()->role !== 'warehouse_staff')
                        <td><span class="amount">{{ number_format($item->price, 2) }} FCFA</span></td>
                        @endif
                        <td>
                            <span style="font-weight:700;font-size:1rem;color:{{ $item->quantity < 5 ? '#ef4444' : ($item->quantity < 10 ? '#f59e0b' : 'var(--text-primary)') }};">
                                {{ $item->quantity }}
                            </span>
                        </td>
                        <td>
                            @if($item->quantity < 5)
                                <span class="badge badge-danger">⚠ Low Stock</span>
                            @elseif($item->quantity < 10)
                                <span class="badge badge-warning">Low</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                        </td>
                        @if(Auth::user()->role !== 'warehouse_staff')
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-ghost btn-sm">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Edit
                                </a>
                                @if(Auth::user()->role === 'admin')
                                <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete {{ addslashes($item->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="1.5"/></svg>
                <h3>No items yet</h3>
                <p>Add your first inventory item to get started.</p>
                @if(Auth::user()->role !== 'warehouse_staff')
                    <a href="{{ route('items.create') }}" class="btn btn-primary">Add Item</a>
                @endif
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
