<x-guest-layout>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="success-box">{{ session('status') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.2rem;">
        @csrf

        {{-- Email --}}
        <div>
            <label class="label-text" for="email">Email Address</label>
            <input
                id="email"
                class="glass-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="label-text" for="password">Password</label>
            <div class="pwd-wrap">
                <input
                    id="password"
                    class="glass-input"
                    type="password"
                    name="password"
                    placeholder="••••••••••••"
                    required
                    autocomplete="current-password"
                    style="padding-right:3rem;"
                >
                <button type="button" class="pwd-toggle" onclick="togglePwd()" id="pwd-toggle-btn" title="Show/hide password">
                    <svg id="eye-open" width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    <svg id="eye-closed" width="18" height="18" fill="none" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
            @error('password')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember"
                    style="width:15px;height:15px;accent-color:#6366f1;cursor:pointer;">
                <span style="color:rgba(255,255,255,0.6);font-size:0.83rem;">Remember me</span>
            </label>
        </div>

        {{-- Sign In Button --}}
        <button type="submit" class="sign-in-btn" id="signin-btn">
            SIGN IN
        </button>

        {{-- Register Link --}}

    </form>

    <script>
        function togglePwd() {
            const input = document.getElementById('password');
            const open  = document.getElementById('eye-open');
            const closed = document.getElementById('eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                open.style.display = 'none';
                closed.style.display = 'inline';
            } else {
                input.type = 'password';
                open.style.display = 'inline';
                closed.style.display = 'none';
            }
        }

        // Button loading state
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('signin-btn');
            btn.textContent = 'SIGNING IN...';
            btn.style.opacity = '0.8';
        });
    </script>
</x-guest-layout>
