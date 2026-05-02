<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — CineX Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/cinex.css') }}">
    @stack('styles')
</head>
<body>
<div class="admin-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">CINE<span>X</span> <span style="font-size:11px;color:var(--text-3);font-weight:400;">Admin</span></div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">&#9632;</span> Dashboard
            </a>
            <a href="{{ route('admin.movies.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                <span class="icon">&#127909;</span> Movies
            </a>
            <a href="{{ route('admin.theaters.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.theaters.*') ? 'active' : '' }}">
                <span class="icon">&#127968;</span> Theaters
            </a>
            <a href="{{ route('admin.shows.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.shows.*') ? 'active' : '' }}">
                <span class="icon">&#128197;</span> Shows
            </a>
            <a href="{{ route('admin.bookings.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <span class="icon">&#127915;</span> Bookings
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="icon">&#128101;</span> Users
            </a>
            <div style="border-top:1px solid var(--border-1);margin:1rem 0;"></div>
            <a href="{{ url('/') }}" class="sidebar-link">
                <span class="icon">&#8592;</span> Back to Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;text-align:left;background:none;border:none;">
                    <span class="icon">&#10006;</span> Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="admin-content">
        <div class="admin-topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button id="sidebarToggle" style="background:none;border:none;color:var(--text-2);font-size:18px;cursor:pointer;">&#9776;</button>
                <h4 style="font-size:15px;font-weight:600;">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div style="font-size:13px;color:var(--text-3);">
                Logged in as <span style="color:var(--white);font-weight:600;">{{ auth()->user()->name }}</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        <div style="padding:0 1.5rem;">
            @if(session('success'))
                <div class="alert alert-success mt-2">&#10003; {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error mt-2">&#9888; {{ session('error') }}</div>
            @endif
        </div>

        <div class="admin-page">
            @yield('content')
        </div>
    </div>
</div>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('adminSidebar').classList.toggle('open');
    });
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