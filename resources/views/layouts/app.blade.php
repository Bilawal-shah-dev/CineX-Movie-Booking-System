<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CineX — Book Your Perfect Seat')</title>

    {{-- Favicon --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎬</text></svg>">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- CineX CSS --}}
    <link rel="stylesheet" href="{{ asset('css/cinex.css') }}">

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">CINE<span>X</span></a>

        <ul class="navbar-nav" id="mainNav">
            <li><a href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('movies.index') }}"
                class="{{ request()->routeIs('movies.*') ? 'active' : '' }}">Movies</a></li>
            @auth
                <li><a href="{{ route('bookings.history') }}"
                    class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">My Bookings</a></li>
                @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.*') ? 'active' : '' }}"
                        style="color: var(--red);">Admin Panel</a></li>
                @endif
            @endauth
            @auth
    <span style="font-size:13px; color:var(--text-2); margin-right:4px; display:flex; align-items:center; gap:8px;">
        <!-- @if(auth()->user()->avatar)
            <img src="{{ asset('images/avatars/'.auth()->user()->avatar) }}"
                 style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:1px solid var(--border-2);">
        @else
            <div style="width:28px;height:28px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
        @endif -->
        <!-- Hi, {{ explode(' ', auth()->user()->name)[0] }} -->
    </span>
@endauth
        </ul>

        <div class="navbar-actions">
    @guest
        <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Sign In</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
    @else
        <div style="display:flex;align-items:center;gap:8px;">
            {{-- First letter avatar --}}
            <div style="width:32px;height:32px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;flex-shrink:0;border:2px solid rgba(255,255,255,.15);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span style="font-size:13px;color:var(--text-2);">Hi, {{ explode(' ', auth()->user()->name)[0] }}</span>
        </div>
        <a href="{{ route('profile.index') }}" class="btn btn-outline btn-sm">Profile</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-sm" style="background:transparent;border:1px solid var(--border-3);color:var(--text-3);">
                Logout
            </button>
        </form>
    @endguest
    <button class="navbar-toggler" id="navToggler" aria-label="Menu">&#9776;</button>
</div>
    </nav>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="container mt-2">
            <div class="alert alert-success">&#10003; {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-2">
            <div class="alert alert-error">&#9888; {{ session('error') }}</div>
        </div>
    @endif
    @if(session('warning'))
        <div class="container mt-2">
            <div class="alert alert-warning">&#9888; {{ session('warning') }}</div>
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
    <div class="container">
        <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:2.5rem;padding-bottom:2rem;flex-wrap:wrap;">

            {{-- Brand --}}
            <div>
                <div style="font-size:24px;font-weight:900;letter-spacing:-.02em;margin-bottom:.75rem;">
                    CINE<span style="color:var(--red);">X</span>
                </div>
                <p style="font-size:13px;color:var(--text-3);line-height:1.7;max-width:240px;margin-bottom:1rem;">
                    Pakistan's premier online cinema ticket booking platform. Book your perfect seat today.
                </p>
                <div style="font-size:12px;color:var(--text-3);">📍 Karachi, Pakistan</div>
                <div style="font-size:12px;color:var(--text-3);margin-top:3px;">✉️ support@cinex.pk</div>
            </div>

            {{-- Quick Links --}}
            <div>
                <p style="font-size:11px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.875rem;">Quick Links</p>
                @foreach([
                    [route('home'),          'Home'],
                    [route('movies.index'),  'Movies'],
                    [route('pages.about'),   'About Us'],
                    [route('pages.faq'),     'FAQ'],
                ] as $l)
                <a href="{{ $l[0] }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">
                    {{ $l[1] }}
                </a>
                @endforeach
            </div>

            {{-- Company --}}
            <div>
                <p style="font-size:11px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.875rem;">Company</p>
                @foreach([
                    [route('pages.team'),    'Our Team'],
                    [route('pages.careers'), 'Careers'],
                    [route('pages.contact'), 'Contact Us'],
                    [route('pages.terms'),   'Terms of Use'],
                    [route('pages.privacy'), 'Privacy Policy'],
                ] as $l)
                <a href="{{ $l[0] }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">
                    {{ $l[1] }}
                </a>
                @endforeach
            </div>

            {{-- Account --}}
            <div>
                <p style="font-size:11px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.875rem;">Account</p>
                @guest
                <a href="{{ route('login') }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">Sign In</a>
                <a href="{{ route('register') }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">Register</a>
                @else
                <a href="{{ route('profile.index') }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">My Profile</a>
                <a href="{{ route('bookings.history') }}" style="display:block;font-size:13px;color:var(--text-2);margin-bottom:.5rem;text-decoration:none;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-2)'">My Bookings</a>
                @endguest
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} CineX. All rights reserved. Built with ❤️ in Karachi.</span>
            <span style="font-size:11px;color:var(--text-4);">Aptech eProject — Sem 2 — 2026</span>
        </div>
    </div>
</footer>

    {{-- JS --}}
    <script>
        // Navbar mobile toggle
        document.getElementById('navToggler').addEventListener('click', function() {
            document.getElementById('mainNav').classList.toggle('open');
        });

        // Flash message auto-hide after 4 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(el) {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>