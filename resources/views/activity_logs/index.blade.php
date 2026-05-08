<x-app-layout>
    <x-slot name="header">Audit Trail</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">System Activity Logs</div>
            <div class="page-hdr-sub">Track every critical action performed in the system</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title">Recent Activity</span></div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td style="font-size:0.8rem;color:var(--text-secondary);">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <div style="width:24px;height:24px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:0.6rem;font-weight:700;">
                                    {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:600;">{{ $log->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $color = match($log->action) {
                                    'CREATED' => '#10b981',
                                    'UPDATED' => '#3b82f6',
                                    'DELETED' => '#ef4444',
                                    'STATUS_CHANGE' => '#f59e0b',
                                    default => '#6b7280'
                                };
                            @endphp
                            <span class="badge" style="background:{{ $color }}15;color:{{ $color }};border:1px solid {{ $color }}30;font-size:0.7rem;">{{ $log->action }}</span>
                        </td>
                        <td><span style="font-size:0.75rem;font-weight:700;color:var(--text-secondary);">{{ $log->subject_type ?? 'SYSTEM' }}</span></td>
                        <td style="font-size:0.875rem;">{{ $log->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1rem;">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
