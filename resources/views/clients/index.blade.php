<x-app-layout>
    <x-slot name="header">Clients</x-slot>
    @include('components.page-styles')

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Clients</div>
            <div class="page-hdr-sub">Manage entities receiving stock (Customers/Departments)</div>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Add New Client
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Clients</span>
        </div>

        @if($clients->count())
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                    <tr>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $client->name }}</td>
                        <td>{{ $client->contact_person ?? '—' }}</td>
                        <td>{{ $client->email ?? '—' }}</td>
                        <td>{{ $client->phone ?? '—' }}</td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-ghost btn-sm" title="Edit">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                @if(Auth::user()->role === 'admin')
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Delete this client?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:#ef4444;" title="Delete">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m12-10a4 4 0 11-8 0 4 4 0 018 0zm5 5l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h3>No clients found</h3>
                <p>Start by adding your first customer or department.</p>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client</a>
            </div>
        @endif
    </div>
</x-app-layout>
