<x-app-layout>
    <x-slot name="header">Categories</x-slot>
    @include('components.page-styles')

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Categories</div>
            <div class="page-hdr-sub">Organise your inventory by product categories</div>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Add Category
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Categories ({{ $categories->count() }})</span>
        </div>

        @if($categories->count())
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $i => $category)
                    <tr>
                        <td style="color:var(--text-secondary);font-size:0.78rem;font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.65rem;">
                                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(139,92,246,0.15));display:flex;align-items:center;justify-content:center;">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <span style="font-weight:600;">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td style="color:var(--text-secondary);">{{ $category->description ?? '—' }}</td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost btn-sm">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Edit
                                </a>
                                @if(Auth::user()->role === 'admin')
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete {{ addslashes($category->name) }}? Items in this category may be affected.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        Delete
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
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="1.5"/></svg>
                <h3>No categories yet</h3>
                <p>Create your first category to organise items.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
            </div>
        @endif
    </div>
</x-app-layout>
