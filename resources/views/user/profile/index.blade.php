@extends('layouts.app')
@section('title', 'My Profile — CineX')

@section('content')

<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); padding:2rem 0;">
    <div class="container">
        <h1 style="font-size:28px; font-weight:800;">My Profile</h1>
        <p style="color:var(--text-3); margin-top:4px; font-size:14px;">Manage your account settings and view booking history</p>
    </div>
</div>

<section style="padding:2.5rem 0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:360px 1fr; gap:2rem; align-items:start;">

            {{-- Profile Card --}}
            <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-lg); overflow:hidden; position:sticky; top:80px;">

                {{-- Avatar header --}}
                {{-- Avatar - Initials only --}}
<div style="text-align:center;margin:1.5rem 0;">
    <div style="width:90px;height:90px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;font-size:38px;font-weight:900;color:#fff;margin:0 auto 12px;border:3px solid rgba(255,255,255,.12);">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <div style="font-size:18px;font-weight:800;">{{ auth()->user()->name }}</div>
    <div style="font-size:13px;color:var(--text-3);margin-top:3px;">{{ auth()->user()->email }}</div>
    @if(auth()->user()->is_admin)
        <span class="badge badge-red" style="margin-top:8px;display:inline-block;">Admin</span>
    @endif
</div>

                {{-- Edit form --}}
                <div style="padding:1.5rem;">
                    @if(session('success'))
                        <div class="alert alert-success" style="margin-bottom:1rem;">✓ {{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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
                                   placeholder="03XX-XXXXXXX">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                   value="{{ old('dob', auth()->user()->dob) }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>

                    <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid var(--border-1);">
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:var(--text-3); margin-bottom:6px;">
                            <span>Member since</span>
                            <span style="color:var(--white);">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:13px; color:var(--text-3);">
                            <span>Total Bookings</span>
                            <span style="color:var(--orange); font-weight:700;">{{ $bookings->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            

            {{-- Bookings --}}
            <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                    <h2 class="section-title">Booking History</h2>
                    <a href="{{ route('bookings.history') }}" class="btn btn-outline btn-sm">View All</a>
                </div>

                @forelse($bookings->take(5) as $booking)
                <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-md); padding:1.25rem; margin-bottom:.875rem; transition:border-color .2s;"
                     onmouseover="this.style.borderColor='var(--border-3)'" onmouseout="this.style.borderColor='var(--border-1)'">
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:44px; height:60px; background:linear-gradient(135deg,#1a0000,#2d0808); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">🎬</div>
                            <div>
                                <div style="font-size:15px; font-weight:700; margin-bottom:3px;">{{ $booking->show->movie->title }}</div>
                                <div style="font-size:12px; color:var(--text-3);">
                                    {{ $booking->show->show_date->format('d M Y') }} &bull;
                                    {{ \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A') }} &bull;
                                    {{ $booking->show->theater->name }}
                                </div>
                                <div style="font-family:var(--font-mono); font-size:11px; color:var(--orange); margin-top:3px;">{{ $booking->booking_id }}</div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:16px; font-weight:800; color:var(--orange);">Rs. {{ number_format($booking->total_amount) }}</div>
                            <span class="badge {{ $booking->status==='confirmed'?'badge-green':'badge-red' }}" style="margin-top:4px; display:inline-block;">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <div style="margin-top:6px;">
                                <a href="{{ route('booking.confirm', $booking->id) }}"
                                   class="btn btn-outline btn-sm" style="font-size:11px; padding:4px 10px;">
                                   View Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:3rem 0; color:var(--text-3);">
                    <div style="font-size:48px; margin-bottom:1rem;">🎟️</div>
                    <p style="margin-bottom:1rem;">No bookings yet.</p>
                    <a href="{{ route('movies.index') }}" class="btn btn-primary">Browse Movies</a>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</section>
 
@endsection