<x-app-layout>
    <x-slot name="header">Users</x-slot>
    @include('components.page-styles')

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2"/><polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">User Management</div>
            <div class="page-hdr-sub">Manage system users and their role permissions</div>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><line x1="19" y1="8" x2="19" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="22" y1="11" x2="16" y2="11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Add User
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Users ({{ $users->count() }})</span>
            <div class="search-bar" style="width:220px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" placeholder="Search users..." oninput="filterTable(this,'usersTable')">
            </div>
        </div>

        @if($users->count())
        <div style="overflow-x:auto;">
            <table class="data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.65rem;">
                                <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <div>
                                    <div style="font-weight:600;">{{ $user->name }}</div>
                                    @if($user->id === Auth::id())
                                        <div style="font-size:0.7rem;color:#6366f1;font-weight:500;">(You)</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--text-secondary);">{{ $user->email }}</td>
                        <td>
                            @php
                                $roleBadge = match($user->role) {
                                    'admin'         => 'badge-info',
                                    'stock_manager' => 'badge-warning',
                                    default         => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $roleBadge }}">{{ str_replace('_', ' ', $user->role) }}</span>
                        </td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="badge badge-success">● Active</span>
                            @else
                                <span class="badge badge-danger">● Suspended</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell" style="justify-content:flex-end;">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-ghost btn-sm">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Edit
                                </a>
                                @if($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
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
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.5"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5"/></svg>
                <h3>No users yet</h3>
                <p>Add team members to get started.</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
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
