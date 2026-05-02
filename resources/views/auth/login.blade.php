@extends('layouts.app')
@section('title', 'Sign In — CineX')

@section('content')
<div style="min-height:calc(100vh - 64px); display:flex; align-items:center; justify-content:center; padding:2rem 1rem; background: radial-gradient(ellipse at 50% 0%, rgba(211,47,35,0.08) 0%, transparent 60%);">
    <div style="width:100%; max-width:420px;">

        <div class="text-center mb-4">
            <div style="font-size:32px; font-weight:900; letter-spacing:-.03em; margin-bottom:6px;">
                CINE<span class="text-red">X</span>
            </div>
            <h2 style="font-size:22px; font-weight:700; margin-bottom:6px;">Welcome back</h2>
            <p class="text-muted text-small">Sign in to book your seats</p>
        </div>

        <div class="card" style="background:var(--surface-2); border:1px solid var(--border-2);">
            <div class="card-body" style="padding:2rem;">

                @if($errors->any())
                    <div class="alert alert-error">
                        &#9888; {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="you@example.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="display:flex; justify-content:space-between;">
                            <span>Password</span>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-red" style="font-size:11px;">Forgot password?</a>
                            @endif
                        </label>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••••" required>
                    </div>

                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:1.5rem;">
                        <input type="checkbox" name="remember" id="remember" style="accent-color:var(--red);">
                        <label for="remember" style="font-size:13px; color:var(--text-2); cursor:pointer;">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        Sign In
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center mt-3 text-small text-muted">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-red" style="font-weight:600;">Create one free</a>
        </p>
    </div>
</div>
@endsection