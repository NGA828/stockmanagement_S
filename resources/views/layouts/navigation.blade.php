<aside class="sidebar" id="appSidebar">

    {{-- Brand Logo --}}
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="white" stroke-width="2" stroke-linecap="round"/>
                <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <span class="logo-text">Stock<span>Pro</span></span>
    </a>

    {{-- ── MAIN NAV ── --}}
    <nav style="flex:1; padding: 0.75rem 0;">

        {{-- Overview --}}
        <p class="sidebar-section-label">Overview</p>

        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2"/>
            </svg>
            Dashboard
        </a>

        {{-- ── INVENTORY ── --}}
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager')
        <p class="sidebar-section-label">Inventory</p>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager')
            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Categories
            </a>
            @endif

            <a href="{{ route('items.index') }}"
               class="nav-item {{ request()->routeIs('items.*') ? 'active' : '' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/>
                </svg>
                All Items
            </a>

        @else
        {{-- Viewer: show items without section label --}}
        <p class="sidebar-section-label">Inventory</p>
        <a href="{{ route('items.index') }}"
           class="nav-item {{ request()->routeIs('items.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="2"/>
            </svg>
            Items
        </a>
        @endif

        {{-- ── ORDERS & TRANSACTIONS ── --}}
        <p class="sidebar-section-label">Operations</p>

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager')
        <a href="{{ route('orders.index') }}"
           class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"/>
                <path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Purchase Orders
        </a>

        <a href="{{ route('dispatches.index') }}"
           class="nav-item {{ request()->routeIs('dispatches.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M5 8h14M5 12h14M5 16h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="2"/>
            </svg>
            Dispatches (OUT)
        </a>

        <a href="{{ route('suppliers.index') }}"
           class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Suppliers
        </a>

        <a href="{{ route('clients.index') }}"
           class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m12-10a4 4 0 11-8 0 4 4 0 018 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Clients
        </a>
        @endif

        <a href="{{ route('transactions.index') }}"
           class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <polyline points="17 1 21 5 17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M21 13v2a4 4 0 01-4 4H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Transactions
        </a>

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'stock_manager')
        <p class="sidebar-section-label">Analytics</p>

        <a href="{{ route('orders.procurement') }}"
           class="nav-item {{ request()->routeIs('orders.procurement') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
            </svg>
            Procurement
        </a>

        <a href="{{ route('reports.index') }}"
           class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M18 20V10M12 20V4M6 20v-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Reports
        </a>
        @endif
        @if(Auth::user()->role === 'admin')
        <p class="sidebar-section-label">Admin</p>

        <a href="{{ route('users.index') }}"
           class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Users
        </a>

        <a href="{{ route('activity-logs.index') }}"
           class="nav-item {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Audit Trail
        </a>
        @endif

    </nav>

    {{-- ── SIDEBAR FOOTER (user chip) ── --}}
    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div class="user-chip-name">{{ Str::limit(Auth::user()->name, 18) }}</div>
                <div class="user-chip-role">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
            </div>
        </div>
    </div>
</aside>
