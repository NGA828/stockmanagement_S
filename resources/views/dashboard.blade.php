<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <style>
        /* ── Dashboard Styles ── */
        .dash-welcome {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 2px;
            margin-bottom: 1.75rem;
        }

        /* Stat Cards Grid */
        .stat-grid {
            display: grid;
            gap: 1.1rem;
            margin-bottom: 1.75rem;
        }
        .stat-grid-4 { grid-template-columns: repeat(4, 1fr); }
        .stat-grid-3 { grid-template-columns: repeat(3, 1fr); }
        .stat-grid-2 { grid-template-columns: repeat(2, 1fr); }

        .stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 1.25rem 1.4rem;
            border: 1px solid var(--header-border);
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 0.85rem; }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-icon-blue   { background: rgba(99,102,241,0.12);  color: #6366f1; }
        .stat-icon-amber  { background: rgba(245,158,11,0.12);  color: #f59e0b; }
        .stat-icon-green  { background: rgba(16,185,129,0.12);  color: #10b981; }
        .stat-icon-rose   { background: rgba(239,68,68,0.12);   color: #ef4444; }
        .stat-icon-purple { background: rgba(139,92,246,0.12);  color: #8b5cf6; }

        .stat-badge {
            font-size: 0.7rem; font-weight: 600;
            padding: 0.2rem 0.5rem; border-radius: 100px;
            display: flex; align-items: center; gap: 0.25rem;
        }
        .stat-badge-up   { background: rgba(16,185,129,0.12); color: #10b981; }
        .stat-badge-down { background: rgba(239,68,68,0.12);  color: #ef4444; }
        .stat-badge-neutral { background: rgba(107,114,128,0.12); color: #6b7280; }

        .stat-value { font-size: 1.85rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1; }
        .stat-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 500; margin-top: 0.3rem; }

        /* Two column layout */
        .dash-row {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.25rem;
            align-items: start;
        }

        /* Card panel */
        .panel {
            background: var(--card-bg);
            border: 1px solid var(--header-border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .panel-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid var(--header-border);
        }
        .panel-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
        .panel-link {
            font-size: 0.78rem; font-weight: 600; color: #6366f1; text-decoration: none;
        }
        .panel-link:hover { text-decoration: underline; }

        /* Activity Table */
        .activity-table { width: 100%; border-collapse: collapse; }
        .activity-table th {
            font-size: 0.72rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--text-secondary);
            padding: 0.65rem 1.4rem; text-align: left;
            border-bottom: 1px solid var(--header-border);
            background: transparent;
        }
        .activity-table td {
            padding: 0.85rem 1.4rem;
            border-bottom: 1px solid var(--header-border);
            font-size: 0.84rem; color: var(--text-primary);
        }
        .activity-table tr:last-child td { border-bottom: none; }
        .activity-table tr:hover td { background: var(--main-bg); transition: background 0.15s; }

        .type-badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            font-size: 0.72rem; font-weight: 600;
            padding: 0.2rem 0.55rem; border-radius: 100px;
        }
        .type-in   { background: rgba(16,185,129,0.12);  color: #10b981; }
        .type-out  { background: rgba(239,68,68,0.12);   color: #ef4444; }
        .type-adj  { background: rgba(245,158,11,0.12);  color: #f59e0b; }
        .type-pending  { background: rgba(245,158,11,0.12); color: #d97706; }
        .type-approved { background: rgba(16,185,129,0.12); color: #059669; }
        .type-rejected { background: rgba(239,68,68,0.12);  color: #dc2626; }

        /* Low Stock Alerts */
        .stock-item {
            padding: 0.9rem 1.4rem;
            border-bottom: 1px solid var(--header-border);
        }
        .stock-item:last-child { border-bottom: none; }
        .stock-item-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
        .stock-item-sku  { font-size: 0.72rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
        .stock-bar-wrap  { display: flex; align-items: center; gap: 0.65rem; }
        .stock-bar-track {
            flex: 1; height: 6px; border-radius: 3px;
            background: var(--header-border); overflow: hidden;
        }
        .stock-bar-fill  { height: 100%; border-radius: 3px; transition: width 0.6s ease; }
        .stock-bar-critical { background: #ef4444; }
        .stock-bar-low      { background: #f59e0b; }
        .stock-qty { font-size: 0.72rem; font-weight: 700; min-width: 60px; text-align: right; }
        .stock-qty-critical { color: #ef4444; }
        .stock-qty-low      { color: #f59e0b; }

        /* Empty state */
        .empty-state {
            text-align: center; padding: 2.5rem 1.5rem;
            color: var(--text-secondary); font-size: 0.85rem;
        }
        .empty-state svg { margin-bottom: 0.75rem; opacity: 0.35; }

        /* Role alert banner */
        .role-banner {
            display: flex; align-items: center; gap: 0.75rem;
            background: rgba(99,102,241,0.07); border: 1px solid rgba(99,102,241,0.2);
            border-radius: 10px; padding: 0.75rem 1.1rem;
            font-size: 0.84rem; color: #4f46e5; font-weight: 500;
            margin-bottom: 1.25rem;
        }
        .dark .role-banner { background: rgba(99,102,241,0.12); color: #a5b4fc; }
        .role-badge-lg {
            display: inline-block; font-size: 0.75rem; font-weight: 700;
            background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff;
            padding: 0.2rem 0.65rem; border-radius: 100px; letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        @media (max-width: 1100px) {
            .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
            .stat-grid-3 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .stat-grid-4, .stat-grid-3, .stat-grid-2 { grid-template-columns: 1fr 1fr; }
            .dash-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .stat-grid-4, .stat-grid-3, .stat-grid-2 { grid-template-columns: 1fr; }
        }
    </style>

    {{-- Role welcome banner --}}
    <div class="role-banner">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        Welcome back, <strong>{{ Auth::user()->name }}</strong>! You're signed in as
        <span class="role-badge-lg">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
    </div>

    {{-- ─────────────────────────────────
         ADMIN DASHBOARD
    ───────────────────────────────── --}}
    @if(Auth::user()->role === 'admin')

        <div class="stat-grid stat-grid-4">
            {{-- Total Items --}}
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-blue">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l8 16H4z"/></svg>
                        Live
                    </span>
                </div>
                <div class="stat-value">{{ number_format($totalItems) }}</div>
                <div class="stat-label">Total Items</div>
            </div>

            {{-- Pending Orders --}}
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-amber">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"/><path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="stat-badge {{ $pendingOrders > 0 ? 'stat-badge-down' : 'stat-badge-neutral' }}">
                        Pending
                    </span>
                </div>
                <div class="stat-value">{{ number_format($pendingOrders) }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>

            {{-- Today's Transactions --}}
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-green">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M21 13v2a4 4 0 01-4 4H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">Today</span>
                </div>
                <div class="stat-value">{{ number_format($todayTransactions) }}</div>
                <div class="stat-label">Today's Transactions</div>
            </div>

            {{-- Total Users --}}
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-purple">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">Total</span>
                </div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>

    {{-- ─────────────────────────────────
         STOCK MANAGER DASHBOARD
    ───────────────────────────────── --}}
    @elseif(Auth::user()->role === 'stock_manager')

        <div class="stat-grid stat-grid-3">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-blue">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">Live</span>
                </div>
                <div class="stat-value">{{ number_format($totalItems) }}</div>
                <div class="stat-label">Total Items</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-amber">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"/><path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="stat-badge {{ $pendingOrders > 0 ? 'stat-badge-down' : 'stat-badge-neutral' }}">Pending</span>
                </div>
                <div class="stat-value">{{ number_format($pendingOrders) }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-rose">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="stat-badge {{ $needingAttention > 0 ? 'stat-badge-down' : 'stat-badge-neutral' }}">Action Required</span>
                </div>
                <div class="stat-value">{{ number_format($needingAttention) }}</div>
                <div class="stat-label">Items Near Low Stock</div>
            </div>
        </div>

    {{-- ─────────────────────────────────
         VIEWER DASHBOARD
    ───────────────────────────────── --}}
    @else

        <div class="stat-grid stat-grid-2">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-blue">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">Live</span>
                </div>
                <div class="stat-value">{{ number_format($totalItems) }}</div>
                <div class="stat-label">Total Items</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon stat-icon-green">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M21 13v2a4 4 0 01-4 4H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="stat-badge stat-badge-up">Today</span>
                </div>
                <div class="stat-value">{{ number_format($todayTransactions) }}</div>
                <div class="stat-label">Today's Transactions</div>
            </div>
        </div>

    @endif

    {{-- ─────────────────────────────────
         MAIN CONTENT ROW
    ───────────────────────────────── --}}
    <div class="dash-row">

        {{-- Left: Recent Activity --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Recent Activity</span>
                <a href="{{ route('transactions.index') }}" class="panel-link">View All →</a>
            </div>

            @if($recentTransactions->count())
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $tx)
                            <tr>
                                <td>
                                    <div style="font-weight:600;font-size:0.84rem;">{{ $tx->item->name ?? 'Unknown' }}</div>
                                    @if($tx->notes)
                                        <div style="font-size:0.73rem;color:var(--text-secondary);margin-top:1px;">{{ Str::limit($tx->notes, 35) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $typeClass = match($tx->type ?? '') {
                                            'in', 'stock_in'   => 'type-in',
                                            'out', 'stock_out' => 'type-out',
                                            default            => 'type-adj',
                                        };
                                        $typeLabel = match($tx->type ?? '') {
                                            'in', 'stock_in'   => '↑ Stock In',
                                            'out', 'stock_out' => '↓ Stock Out',
                                            default            => '~ Adjust',
                                        };
                                    @endphp
                                    <span class="type-badge {{ $typeClass }}">{{ $typeLabel }}</span>
                                </td>
                                <td style="font-weight:600;">{{ $tx->quantity }}</td>
                                <td style="color:var(--text-secondary);font-size:0.78rem;">
                                    {{ \Carbon\Carbon::parse($tx->transaction_date)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" style="display:block;margin:0 auto 0.75rem;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5"/></svg>
                    No transactions yet today.
                </div>
            @endif
        </div>

        {{-- Right: Low Stock Alerts (admin + stock_manager only) --}}
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager')
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title" style="display:flex;align-items:center;gap:0.4rem;">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="9" x2="12" y2="13" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="17" x2="12.01" y2="17" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/></svg>
                    Low Stock Alert
                </span>
                <a href="{{ route('items.index') }}" class="panel-link">View All →</a>
            </div>

            @if($lowStockItems->count())
                @foreach($lowStockItems as $item)
                    @php
                        $reorderLevel = $item->reorder_level ?? 20;
                        $pct = $reorderLevel > 0 ? min(100, ($item->quantity / $reorderLevel) * 100) : 0;
                        $isCritical = $item->quantity <= 5;
                    @endphp
                    <div class="stock-item">
                        <div class="stock-item-name">{{ $item->name }}</div>
                        <div class="stock-item-sku">SKU: {{ $item->sku ?? 'N/A' }}</div>
                        <div class="stock-bar-wrap">
                            <div class="stock-bar-track">
                                <div class="stock-bar-fill {{ $isCritical ? 'stock-bar-critical' : 'stock-bar-low' }}"
                                     style="width: {{ $pct }}%;">
                                </div>
                            </div>
                            <span class="stock-qty {{ $isCritical ? 'stock-qty-critical' : 'stock-qty-low' }}">
                                Stock: {{ $item->quantity }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" style="display:block;margin:0 auto 0.75rem;"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="#10b981" stroke-width="1.5" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="#10b981" stroke-width="1.5" stroke-linecap="round"/></svg>
                    All stock levels are healthy!
                </div>
            @endif
        </div>
        @else
        {{-- Viewer: show a simple recent orders / items panel --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Quick Links</span>
            </div>
            <div style="padding:1rem 1.4rem;display:flex;flex-direction:column;gap:0.6rem;">
                <a href="{{ route('items.index') }}"
                   style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:10px;border:1px solid var(--header-border);text-decoration:none;color:var(--text-primary);font-size:0.85rem;font-weight:500;transition:all 0.15s;"
                   onmouseover="this.style.borderColor='#6366f1'" onmouseout="this.style.borderColor='var(--header-border)'">
                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(99,102,241,0.1);color:#6366f1;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    Browse All Items
                </a>
                <a href="{{ route('transactions.index') }}"
                   style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:10px;border:1px solid var(--header-border);text-decoration:none;color:var(--text-primary);font-size:0.85rem;font-weight:500;transition:all 0.15s;"
                   onmouseover="this.style.borderColor='#6366f1'" onmouseout="this.style.borderColor='var(--header-border)'">
                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(16,185,129,0.1);color:#10b981;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3 11V9a4 4 0 014-4h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M21 13v2a4 4 0 01-4 4H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    View Transactions
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Admin: Recent Orders table --}}
    @if((Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager') && $recentOrders->count())
    <div class="panel" style="margin-top:1.25rem;">
        <div class="panel-header">
            <span class="panel-title">Recent Orders</span>
            <a href="{{ route('orders.index') }}" class="panel-link">View All →</a>
        </div>
        <table class="activity-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Supplier / Notes</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td style="font-weight:600; color:#6366f1;">#{{ $order->id }}</td>
                        <td>{{ Str::limit($order->notes ?? 'N/A', 40) }}</td>
                        <td>
                            @php
                                $sc = match($order->status) {
                                    'approved' => 'type-approved',
                                    'rejected' => 'type-rejected',
                                    default    => 'type-pending',
                                };
                            @endphp
                            <span class="type-badge {{ $sc }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td style="font-weight:600;">{{ number_format($order->total_amount ?? 0, 2) }}</td>
                        <td style="color:var(--text-secondary);font-size:0.78rem;">
                            {{ $order->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</x-app-layout>
