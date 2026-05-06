<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>StockPro — Intelligent Inventory Management</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
            body { background: #0f172a; color: #fff; overflow-x: hidden; }
            
            .hero-section {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                position: relative;
                overflow: hidden;
            }

            /* Animated background blobs */
            .blob {
                position: absolute; width: 500px; height: 500px;
                background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
                filter: blur(40px); border-radius: 50%; z-index: 1;
            }
            .blob-1 { top: -100px; right: -100px; animation: float 12s infinite alternate; }
            .blob-2 { bottom: -100px; left: -100px; background: radial-gradient(circle, rgba(20,184,166,0.1) 0%, transparent 70%); animation: float 15s infinite alternate-reverse; }
            @keyframes float {
                0% { transform: translate(0, 0) scale(1); }
                100% { transform: translate(30px, 50px) scale(1.1); }
            }

            .navbar {
                display: flex; justify-content: space-between; align-items: center;
                padding: 1.5rem 5%; position: relative; z-index: 10;
            }
            .logo { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
            .logo-icon {
                width: 40px; height: 40px; border-radius: 12px;
                background: linear-gradient(135deg, #6366f1, #4f46e5);
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 8px 20px rgba(99,102,241,0.3);
            }
            .logo-text { font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
            .logo-text span { color: #818cf8; }

            .nav-links { display: flex; gap: 1.5rem; align-items: center; }
            .btn-login { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s; }
            .btn-login:hover { color: #fff; }
            .btn-cta {
                background: #fff; color: #0f172a; padding: 0.65rem 1.4rem;
                border-radius: 100px; text-decoration: none; font-size: 0.9rem;
                font-weight: 600; transition: all 0.2s; box-shadow: 0 4px 12px rgba(255,255,255,0.1);
            }
            .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,255,255,0.2); }

            .hero-content {
                flex: 1; display: flex; flex-direction: column; align-items: center;
                justify-content: center; text-align: center; padding: 0 10% 5rem;
                position: relative; z-index: 10;
            }
            .badge {
                background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2);
                color: #818cf8; padding: 0.5rem 1.25rem; border-radius: 100px;
                font-size: 0.8rem; font-weight: 600; margin-bottom: 2rem;
                letter-spacing: 0.05em; text-transform: uppercase;
            }
            .hero-title {
                font-size: clamp(2.5rem, 8vw, 5.5rem); font-weight: 900;
                line-height: 1; letter-spacing: -0.04em; margin-bottom: 1.5rem;
            }
            .hero-subtitle {
                font-size: clamp(1rem, 2vw, 1.25rem); color: #94a3b8;
                max-width: 600px; line-height: 1.6; margin-bottom: 3rem;
            }
            .hero-btns { display: flex; gap: 1rem; }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff;
                padding: 1rem 2.5rem; border-radius: 12px; text-decoration: none;
                font-size: 1.1rem; font-weight: 700; transition: all 0.3s;
                box-shadow: 0 10px 25px rgba(99,102,241,0.4);
            }
            .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(99,102,241,0.5); }
            
            .dashboard-preview {
                width: 90%; max-width: 1100px; margin: -5rem auto 0;
                background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px; padding: 10px; backdrop-filter: blur(10px);
                position: relative; z-index: 20; box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            }
            .dashboard-preview img { width: 100%; border-radius: 15px; display: block; opacity: 0.9; }

            @media (max-width: 768px) {
                .hero-btns { flex-direction: column; width: 100%; }
                .hero-btns .btn-primary { text-align: center; }
            }
        </style>
    </head>
    <body>
        <div class="hero-section">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>

            <nav class="navbar">
                <a href="/" class="logo">
                    <div class="logo-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                            <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="logo-text">Stock<span>Pro</span></span>
                </a>

                <div class="nav-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-cta">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-cta">Sign In</a>
                    @endauth
                </div>
            </nav>

            <main class="hero-content">
                <div class="badge">Next-Gen Inventory Control</div>
                <h1 class="hero-title">MANAGE STOCK<br>WITHOUT FRICTION.</h1>
                <p class="hero-subtitle">
                    The most intuitive, role-based stock management system built for speed, accuracy, and clarity.
                </p>
                <div class="hero-btns">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Return to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Sign In to StockPro</a>
                    @endauth
                </div>
            </main>
        </div>

        {{-- Visual filler for preview area --}}
        <div class="dashboard-preview">
            <div style="aspect-ratio: 16/9; background: #1e293b; border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 1rem;">
                <svg width="60" height="60" fill="none" viewBox="0 0 24 24" style="opacity: 0.2;">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke="white" stroke-width="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke="white" stroke-width="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke="white" stroke-width="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke="white" stroke-width="2"/>
                </svg>
                <p style="color: rgba(255,255,255,0.2); font-weight: 700; font-size: 1.5rem; letter-spacing: 0.1em;">DASHBOARD INTERFACE</p>
            </div>
        </div>

        <div style="height: 15rem;"></div>
    </body>
</html>