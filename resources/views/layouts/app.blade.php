<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true, darkMode: false }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StockPro') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            html, body { margin: 0; padding: 0; height: 100%; font-family: 'Inter', sans-serif; }

            /* ── CSS Variables ── */
            :root {
                --sidebar-w: 240px;
                --sidebar-bg: #1e1b4b;
                --sidebar-border: rgba(255,255,255,0.07);
                --sidebar-text: rgba(255,255,255,0.65);
                --sidebar-text-active: #fff;
                --sidebar-item-active-bg: rgba(99,102,241,0.85);
                --sidebar-item-hover-bg: rgba(255,255,255,0.07);
                --sidebar-section-label: rgba(255,255,255,0.35);
                --header-bg: #fff;
                --header-border: #e5e7eb;
                --main-bg: #f3f4f6;
                --card-bg: #fff;
                --text-primary: #111827;
                --text-secondary: #6b7280;
                --accent: #6366f1;
                --accent-dark: #4f46e5;
            }
            .dark {
                --header-bg: #1f2937;
                --header-border: #374151;
                --main-bg: #111827;
                --card-bg: #1f2937;
                --text-primary: #f9fafb;
                --text-secondary: #9ca3af;
            }

            /* ── Layout Shell ── */
            .layout-shell { display:flex; min-height:100vh; background:var(--main-bg); }

            /* ── Sidebar ── */
            .sidebar {
                width: var(--sidebar-w);
                min-height: 100vh;
                background: var(--sidebar-bg);
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0; left: 0; bottom: 0;
                z-index: 50;
                transition: transform 0.3s ease;
                overflow-y: auto;
                border-right: 1px solid var(--sidebar-border);
            }
            .sidebar::-webkit-scrollbar { width: 4px; }
            .sidebar::-webkit-scrollbar-track { background: transparent; }
            .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

            .sidebar-logo {
                display: flex; align-items: center; gap: 0.65rem;
                padding: 1.35rem 1.25rem;
                border-bottom: 1px solid var(--sidebar-border);
                text-decoration: none;
            }
            .logo-icon {
                width: 34px; height: 34px;
                background: linear-gradient(135deg, #6366f1, #4f46e5);
                border-radius: 9px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
                box-shadow: 0 4px 12px rgba(99,102,241,0.4);
            }
            .logo-text { color: #fff; font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
            .logo-text span { color: #818cf8; }

            .sidebar-section-label {
                font-size: 0.68rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: var(--sidebar-section-label);
                padding: 1rem 1.25rem 0.35rem;
            }

            .nav-item {
                display: flex; align-items: center; gap: 0.7rem;
                padding: 0.55rem 1.25rem;
                color: var(--sidebar-text);
                font-size: 0.875rem; font-weight: 500;
                text-decoration: none;
                border-radius: 8px;
                margin: 1px 0.65rem;
                transition: all 0.15s ease;
                position: relative;
            }
            .nav-item:hover {
                background: var(--sidebar-item-hover-bg);
                color: var(--sidebar-text-active);
            }
            .nav-item.active {
                background: var(--sidebar-item-active-bg);
                color: var(--sidebar-text-active);
                box-shadow: 0 2px 8px rgba(99,102,241,0.35);
            }
            .nav-item svg { flex-shrink: 0; opacity: 0.8; }
            .nav-item.active svg { opacity: 1; }

            .nav-sub-item {
                display: flex; align-items: center; gap: 0.7rem;
                padding: 0.45rem 1.25rem 0.45rem 2.7rem;
                color: var(--sidebar-text);
                font-size: 0.83rem; font-weight: 400;
                text-decoration: none;
                border-radius: 8px;
                margin: 1px 0.65rem;
                transition: all 0.15s ease;
            }
            .nav-sub-item:hover { background: var(--sidebar-item-hover-bg); color: var(--sidebar-text-active); }
            .nav-sub-item.active { color: #a5b4fc; font-weight: 500; }

            .sidebar-footer {
                margin-top: auto;
                padding: 1rem;
                border-top: 1px solid var(--sidebar-border);
            }
            .user-chip {
                display: flex; align-items: center; gap: 0.65rem;
                padding: 0.6rem 0.8rem;
                border-radius: 10px;
                cursor: pointer;
                transition: background 0.15s;
            }
            .user-chip:hover { background: rgba(255,255,255,0.07); }
            .user-avatar {
                width: 32px; height: 32px;
                background: linear-gradient(135deg, #6366f1, #a78bfa);
                border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.75rem; font-weight: 700; color: #fff;
                flex-shrink: 0;
            }
            .user-chip-name { color: #fff; font-size: 0.83rem; font-weight: 600; }
            .user-chip-role { color: rgba(255,255,255,0.45); font-size: 0.72rem; text-transform: capitalize; }

            /* ── Main Area ── */
            .main-area {
                margin-left: var(--sidebar-w);
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                transition: margin-left 0.3s ease;
            }

            .top-header {
                background: var(--header-bg);
                border-bottom: 1px solid var(--header-border);
                padding: 0 1.75rem;
                height: 64px;
                display: flex; align-items: center; justify-content: space-between;
                position: sticky; top: 0; z-index: 40;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            .page-title { color: var(--text-primary); font-size: 1.3rem; font-weight: 700; letter-spacing: -0.02em; }
            .page-subtitle { color: var(--text-secondary); font-size: 0.8rem; font-weight: 400; margin-top: 1px; }

            .header-actions { display: flex; align-items: center; gap: 0.75rem; }

            .dark-toggle {
                background: none; border: none; cursor: pointer;
                color: var(--text-secondary); padding: 0.5rem;
                border-radius: 8px; transition: all 0.15s;
                line-height: 0;
            }
            .dark-toggle:hover { background: var(--main-bg); color: var(--text-primary); }

            .hamburger-btn {
                display: none; background: none; border: none;
                cursor: pointer; color: var(--text-secondary); padding: 0.5rem;
                border-radius: 8px; transition: all 0.15s;
            }
            .hamburger-btn:hover { background: var(--main-bg); }

            .header-user-btn {
                display: flex; align-items: center; gap: 0.5rem;
                background: var(--main-bg); border: 1px solid var(--header-border);
                border-radius: 10px; padding: 0.4rem 0.75rem;
                cursor: pointer; transition: all 0.15s; text-decoration: none;
                position: relative;
            }
            .header-user-btn:hover { border-color: var(--accent); }
            .header-user-name { color: var(--text-primary); font-size: 0.85rem; font-weight: 600; }
            .header-user-role {
                font-size: 0.7rem; font-weight: 500;
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
                color: #fff; border-radius: 100px; padding: 0.15rem 0.5rem;
                text-transform: capitalize; letter-spacing: 0.03em;
            }

            /* Dropdown */
            .user-dropdown {
                position: absolute; top: calc(100% + 8px); right: 0;
                background: var(--card-bg);
                border: 1px solid var(--header-border);
                border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.12);
                min-width: 180px; overflow: hidden; z-index: 100;
            }
            .user-dropdown a, .user-dropdown button {
                display: flex; align-items: center; gap: 0.6rem;
                padding: 0.65rem 1rem; color: var(--text-primary);
                font-size: 0.85rem; font-weight: 500; text-decoration: none;
                width: 100%; text-align: left; background: none; border: none; cursor: pointer;
                transition: background 0.1s;
            }
            .user-dropdown a:hover, .user-dropdown button:hover { background: var(--main-bg); }
            .user-dropdown .divider { height: 1px; background: var(--header-border); margin: 0.25rem 0; }

            .page-content { padding: 1.75rem; flex: 1; }

            /* ── Mobile ── */
            .sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,0.5); z-index: 40;
            }

            @media (max-width: 768px) {
                .sidebar { transform: translateX(-100%); }
                .sidebar.open { transform: translateX(0); }
                .sidebar-overlay.open { display: block; }
                .main-area { margin-left: 0; }
                .hamburger-btn { display: flex; }
                .page-title { font-size: 1.1rem; }
                .page-content { padding: 1rem; }
            }

            /* ── Notification bell ── */
            .notif-btn {
                position: relative; background: none; border: none;
                cursor: pointer; color: var(--text-secondary);
                padding: 0.5rem; border-radius: 8px; transition: all 0.15s;
                line-height: 0;
            }
            .notif-btn:hover { background: var(--main-bg); color: var(--text-primary); }
            .notif-dot {
                position: absolute; top: 5px; right: 5px;
                width: 8px; height: 8px;
                background: #ef4444; border-radius: 50%;
                border: 2px solid var(--header-bg);
            }
        </style>
    </head>
    <body>
        <div class="layout-shell">

            {{-- ── SIDEBAR ── --}}
            @include('layouts.navigation')

            {{-- Mobile overlay --}}
            <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

            {{-- ── MAIN AREA ── --}}
            <div class="main-area" id="mainArea">

                {{-- Top Header --}}
                <header class="top-header">
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                                <path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <div>
                            @isset($header)
                                <div class="page-title">{{ $header }}</div>
                            @else
                                <div class="page-title">{{ config('app.name', 'StockPro') }}</div>
                            @endisset
                        </div>
                    </div>

                    <div class="header-actions">
                        {{-- Dark mode toggle --}}
                        <button class="dark-toggle" onclick="document.documentElement.classList.toggle('dark');this.querySelector('.sun').style.display=document.documentElement.classList.contains('dark')?'block':'none';this.querySelector('.moon').style.display=document.documentElement.classList.contains('dark')?'none':'block';" title="Toggle dark mode">
                            <svg class="moon" width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <svg class="sun" width="18" height="18" fill="none" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </button>

                        {{-- Notification --}}
                        <button class="notif-btn" title="Notifications">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <span class="notif-dot"></span>
                        </button>

                        {{-- User dropdown --}}
                        <div style="position:relative;" id="userMenuWrap">
                            <button class="header-user-btn" onclick="toggleUserMenu()" type="button">
                                <span class="header-user-name">{{ Auth::user()->name }}</span>
                                <span class="header-user-role">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </button>
                            <div class="user-dropdown" id="userMenu" style="display:none;">
                                <a href="{{ route('profile.edit') }}">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/></svg>
                                    My Profile
                                </a>
                                <div class="divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="page-content">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('appSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            }
            function toggleUserMenu() {
                const menu = document.getElementById('userMenu');
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            }
            document.addEventListener('click', function(e) {
                const wrap = document.getElementById('userMenuWrap');
                if (wrap && !wrap.contains(e.target)) {
                    const menu = document.getElementById('userMenu');
                    if (menu) menu.style.display = 'none';
                }
            });
        </script>
    </body>
</html>
