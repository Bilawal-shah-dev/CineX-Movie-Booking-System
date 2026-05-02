@extends('layouts.app')
@section('title', 'My Profile — CineX')

@section('content')
<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); padding:2rem 0;">
    <div class="container">
        <h1 style="font-size:28px; font-weight:800;">My Profile</h1>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid; grid-template-columns:380px 1fr; gap:2rem; align-items:start;">

            {{-- Profile Form --}}
            <div class="card">
                <div class="card-header">Edit Profile</div>
                <div class="card-body">
                    <div style="text-align:center; margin-bottom:1.5rem;">
                        <div style="width:80px; height:80px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:800; margin:0 auto 10px;">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </div>
                        <div style="font-size:16px; font-weight:700;">{{ auth()->user()->name }}</div>
                        <div style="font-size:13px; color:var(--text-3);">{{ auth()->user()->email }}</div>
                        @if(auth()->user()->is_admin)
                            <span class="badge badge-red" style="margin-top:6px;">Admin</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   placeholder="0300-0000000">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                   value="{{ old('dob', auth()->user()->dob) }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>

            {{-- Booking History Summary --}}
            <div>
                <h2 class="section-title" style="margin-bottom:1.5rem;">Recent Bookings</h2>
                @forelse($bookings->take(5) as $booking)
                <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-md); padding:1rem 1.25rem; margin-bottom:.75rem; display:flex; align-items:center; justify-content:space-between; gap:1rem;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:44px; height:60px; background:linear-gradient(135deg,#1a0000,#2d0808); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">&#127909;</div>
                        <div>
                            <div style="font-size:14px; font-weight:700;">{{ $booking->show->movie->title }}</div>
                            <div style="font-size:12px; color:var(--text-3); margin-top:2px;">
                                {{ $booking->show->show_date->format('d M Y') }} &bull;
                                {{ \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A') }}
                            </div>
                            <div style="font-family:var(--font-mono); font-size:10px; color:var(--orange); margin-top:3px;">
                                {{ $booking->booking_id }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:15px; font-weight:700; color:var(--orange);">Rs. {{ number_format($booking->total_amount) }}</div>
                        <span class="badge {{ $booking->status === 'confirmed' ? 'badge-green' : 'badge-red' }}" style="margin-top:4px;">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                @empty
                    <div style="color:var(--text-3); font-size:14px; padding:1rem 0;">
                        Abhi koi booking nahi. Koi movie book karein!
                    </div>
                    <a href="{{ route('movies.index') }}" class="btn btn-primary" style="margin-top:.75rem;">Browse Movies</a>
                @endforelse

                @if($bookings->count() > 5)
                    <a href="{{ route('bookings.history') }}" class="btn btn-outline btn-sm" style="margin-top:.75rem;">
                        View All {{ $bookings->count() }} Bookings
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection