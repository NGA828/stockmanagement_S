<x-app-layout>
    <x-slot name="header">Suppliers</x-slot>
    @include('components.page-styles')

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Suppliers</div>
            <div class="page-hdr-sub">Manage your product vendors and contact information</div>
        </div>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Add Supplier
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Suppliers ({{ $suppliers->count() }})</span>
            <div class="search-bar" style="width:240px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" id="supplierSearch" placeholder="Search suppliers..." oninput="filterTable(this,'suppliersTable')">
            </div>
        </div>

        @if($suppliers->count())
        <div style="overflow-x:auto;">
            <table class="data-table" id="suppliersTable">
                <thead>
                    <tr>
                        <th>Supplier Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                    <tr>
                        <td>
                            <div style="font-weight:600;color:var(--text-primary);">{{ $supplier->name }}</div>
                            <div style="font-size:0.75rem;color:var(--text-secondary);">{{ Str::limit($supplier->address, 40) }}</div>
                        </td>
                        <td>{{ $supplier->contact_person ?? '—' }}</td>
                        <td style="color:var(--text-secondary);">{{ $supplier->email ?? '—' }}</td>
                        <td>{{ $supplier->phone ?? '—' }}</td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-ghost btn-sm">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete {{ addslashes($supplier->name) }}? This will not delete past orders.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                <h3>No suppliers yet</h3>
                <p>Start by adding your first product vendor.</p>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
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
