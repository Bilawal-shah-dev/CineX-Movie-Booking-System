@extends('layouts.app')
@section('title', 'Register — CineX')

@section('content')
<div style="min-height:calc(100vh - 64px); display:flex; align-items:center; justify-content:center; padding:2rem 1rem; background: radial-gradient(ellipse at 50% 0%, rgba(211,47,35,0.08) 0%, transparent 60%);">
    <div style="width:100%; max-width:440px;">

        <div class="text-center mb-4">
            <div style="font-size:32px; font-weight:900; letter-spacing:-.03em; margin-bottom:6px;">
                CINE<span class="text-red">X</span>
            </div>
            <h2 style="font-size:22px; font-weight:700; margin-bottom:6px;">Create your account</h2>
            <p class="text-muted text-small">Join CineX and start booking today</p>
        </div>

        <div class="card" style="background:var(--surface-2); border:1px solid var(--border-2);">
            <div class="card-body" style="padding:2rem;">

                @if($errors->any())
                    <div class="alert alert-error">
                        &#9888; {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Muhammad Ali" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               placeholder="0300-0000000" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Min. 8 characters" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Repeat password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        Create Account
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center mt-3 text-small text-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="text-red" style="font-weight:600;">Sign in</a>
        </p>
    </div>
</div>
@endsection