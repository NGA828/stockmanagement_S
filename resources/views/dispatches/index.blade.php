<x-app-layout>
    <x-slot name="header">Dispatches</x-slot>
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
            <div class="page-hdr-title">Stock Dispatches</div>
            <div class="page-hdr-sub">Track and manage outgoing stock to clients</div>
        </div>
        <a href="{{ route('dispatches.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            New Dispatch
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Recent Dispatches</span>
        </div>

        @if($dispatches->count())
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dispatches as $dispatch)
                    <tr>
                        <td style="font-weight:700;color:var(--accent);">{{ $dispatch->dispatch_number }}</td>
                        <td>{{ $dispatch->client->name }}</td>
                        <td>{{ $dispatch->dispatch_date->format('M d, Y') }}</td>
                        <td>{{ $dispatch->user->name }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'draft' => 'badge-info',
                                    'pending' => 'badge-warning',
                                    'shipped' => 'badge-success',
                                    'cancelled' => 'badge-danger'
                                ][$dispatch->status] ?? 'badge-info';
                            @endphp
                            <span class="badge {{ $statusClass }}" style="text-transform:uppercase;">{{ $dispatch->status }}</span>
                        </td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('dispatches.show', $dispatch) }}" class="btn btn-ghost btn-sm" title="View Details">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                @if(($dispatch->status === 'draft' || $dispatch->status === 'cancelled') && Auth::user()->role === 'admin')
                                <form action="{{ route('dispatches.destroy', $dispatch) }}" method="POST" onsubmit="return confirm('Delete this dispatch record permanently?')">
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
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h3>No dispatches found</h3>
                <p>Create a dispatch to record stock leaving the warehouse.</p>
                <a href="{{ route('dispatches.create') }}" class="btn btn-primary">New Dispatch</a>
            </div>
        @endif
    </div>
</x-app-layout>
