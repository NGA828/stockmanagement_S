<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StockPro') }} — Sign In</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

            .login-bg {
                background: linear-gradient(135deg,
                    #0f0c29 0%,
                    #1a1a4e 20%,
                    #0d3b6e 45%,
                    #1a5276 65%,
                    #117a8b 85%,
                    #0e6655 100%
                );
                min-height: 100vh;
                position: relative;
                overflow: hidden;
            }

            /* Animated blobs in background */
            .login-bg::before {
                content: '';
                position: absolute;
                width: 600px; height: 600px;
                background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
                top: -150px; left: -150px;
                border-radius: 50%;
                animation: floatBlob 8s ease-in-out infinite alternate;
            }
            .login-bg::after {
                content: '';
                position: absolute;
                width: 500px; height: 500px;
                background: radial-gradient(circle, rgba(20,184,166,0.2) 0%, transparent 70%);
                bottom: -100px; right: 200px;
                border-radius: 50%;
                animation: floatBlob 10s ease-in-out infinite alternate-reverse;
            }
            @keyframes floatBlob {
                0%   { transform: translateY(0) scale(1); }
                100% { transform: translateY(40px) scale(1.08); }
            }

            /* Grid overlay for texture */
            .login-grid {
                position: absolute; inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
                background-size: 40px 40px;
                pointer-events: none;
            }

            /* Glassmorphism card */
            .glass-card {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 20px;
                box-shadow:
                    0 25px 50px rgba(0,0,0,0.4),
                    inset 0 1px 0 rgba(255,255,255,0.1);
            }

            .glass-input {
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.2);
                border-radius: 10px;
                color: #fff;
                padding: 0.75rem 1rem;
                width: 100%;
                font-size: 0.95rem;
                transition: all 0.2s ease;
                outline: none;
            }
            .glass-input::placeholder { color: rgba(255,255,255,0.45); }
            .glass-input:focus {
                background: rgba(255,255,255,0.15);
                border-color: rgba(99,102,241,0.8);
                box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            }

            .sign-in-btn {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 0.85rem 1rem;
                width: 100%;
                font-weight: 600;
                font-size: 0.95rem;
                letter-spacing: 0.05em;
                cursor: pointer;
                transition: all 0.25s ease;
                text-transform: uppercase;
                box-shadow: 0 4px 15px rgba(99,102,241,0.4);
            }
            .sign-in-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(99,102,241,0.55);
            }
            .sign-in-btn:active { transform: translateY(0); }

            .label-text { color: rgba(255,255,255,0.75); font-size: 0.85rem; font-weight: 500; margin-bottom: 0.4rem; display: block; }
            .link-text { color: rgba(255,255,255,0.65); font-size: 0.83rem; }
            .link-text a { color: rgba(167,139,250,1); text-decoration: underline; }
            .link-text a:hover { color: #fff; }

            /* Hero panel */
            .hero-title {
                font-size: clamp(2.2rem, 5vw, 3.8rem);
                font-weight: 900;
                line-height: 1.05;
                letter-spacing: -0.02em;
                color: #fff;
            }
            .hero-subtitle {
                font-size: 1.1rem;
                color: rgba(255,255,255,0.7);
                margin-top: 1rem;
                font-weight: 400;
                line-height: 1.6;
            }

            /* Floating badge */
            .hero-badge {
                display: inline-flex; align-items: center; gap: 0.5rem;
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.2);
                border-radius: 100px; padding: 0.35rem 1rem;
                color: rgba(255,255,255,0.85); font-size: 0.8rem; font-weight: 500;
                margin-bottom: 1.5rem;
            }
            .hero-badge .dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; animation: pulse-dot 2s infinite; }
            @keyframes pulse-dot {
                0%,100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.5; transform: scale(1.3); }
            }

            /* Stats strip */
            .stat-strip {
                display: flex; gap: 2rem; margin-top: 2.5rem;
            }
            .stat-item { }
            .stat-num { font-size: 1.6rem; font-weight: 800; color: #fff; }
            .stat-lbl { font-size: 0.75rem; color: rgba(255,255,255,0.5); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }

            .divider-line {
                display: flex; align-items: center; gap: 0.8rem;
                color: rgba(255,255,255,0.4); font-size: 0.8rem;
            }
            .divider-line::before, .divider-line::after {
                content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.15);
            }

            .error-msg { color: #fca5a5; font-size: 0.8rem; margin-top: 0.3rem; }
            .alert-box {
                background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
                border-radius: 8px; padding: 0.75rem 1rem;
                color: #fca5a5; font-size: 0.85rem; margin-bottom: 1rem;
            }
            .success-box {
                background: rgba(74,222,128,0.15); border: 1px solid rgba(74,222,128,0.3);
                border-radius: 8px; padding: 0.75rem 1rem;
                color: #86efac; font-size: 0.85rem; margin-bottom: 1rem;
            }

            /* Password toggle */
            .pwd-wrap { position: relative; }
            .pwd-toggle {
                position: absolute; right: 0.9rem; top: 50%; transform: translateY(-50%);
                background: none; border: none; cursor: pointer;
                color: rgba(255,255,255,0.45); padding: 0;
            }
            .pwd-toggle:hover { color: rgba(255,255,255,0.8); }
        </style>
    </head>
    <body style="margin:0;padding:0;">
        <div class="login-bg">
            <div class="login-grid"></div>

            <div style="position:relative; z-index:10; min-height:100vh; display:flex; align-items:center; padding:2rem;">

                {{-- ── LEFT HERO PANEL ── --}}
                <div style="flex:1; max-width:520px; padding:2rem 3rem 2rem 2rem; display:none;" class="hero-panel">
                    {{-- Logo --}}
                    <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:2.5rem;">
                        <div style="width:38px;height:38px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                        </div>
                        <span style="color:#fff;font-weight:700;font-size:1.25rem;letter-spacing:-0.02em;">Stock<span style="color:#818cf8;">Pro</span></span>
                    </div>

                    <div class="hero-badge">
                        <span class="dot"></span>
                        Real-time Stock Management
                    </div>

                    <h1 class="hero-title">
                        MANAGE<br>YOUR STOCK<br><span style="color:#818cf8;">SMARTER.</span>
                    </h1>

                    <p class="hero-subtitle">
                        A powerful role-based inventory system.<br>
                        Track items, orders, and transactions — all from one place.
                    </p>

                    <div class="stat-strip">
                        <div class="stat-item">
                            <div class="stat-num">3</div>
                            <div class="stat-lbl">User Roles</div>
                        </div>
                        <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                        <div class="stat-item">
                            <div class="stat-num">∞</div>
                            <div class="stat-lbl">Products</div>
                        </div>
                        <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                        <div class="stat-item">
                            <div class="stat-num">24/7</div>
                            <div class="stat-lbl">Tracking</div>
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT GLASS CARD ── --}}
                <div style="flex:1; display:flex; justify-content:center; align-items:center;">
                    <div class="glass-card" style="width:100%;max-width:440px; padding:2.5rem 2.5rem;">

                        {{-- Mobile logo (shown only on small screens) --}}
                        <div style="text-align:center; margin-bottom:1.5rem;" class="mobile-logo">
                            <div style="display:inline-flex;align-items:center;gap:0.6rem;">
                                <div style="width:34px;height:34px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:9px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <span style="color:#fff;font-weight:700;font-size:1.1rem;">Stock<span style="color:#818cf8;">Pro</span></span>
                            </div>
                        </div>

                        <h2 style="color:#fff;font-size:1.55rem;font-weight:700;margin:0 0 0.3rem;letter-spacing:-0.02em;">Welcome back</h2>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.87rem;margin:0 0 1.8rem;">Sign in to access your dashboard</p>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <style>
            @media (min-width: 768px) {
                .hero-panel { display: block !important; }
                .mobile-logo { display: none !important; }
            }
        </style>
    </body>
</html>
