@extends('layouts.app')
@section('title', 'My Bookings — CineX')

@section('content')

<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); padding:2rem 0;">
    <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h1 style="font-size:28px; font-weight:800;">My Bookings</h1>
                <p style="color:var(--text-3); margin-top:4px; font-size:14px;">All your ticket bookings in one place</p>
            </div>
            <span class="badge badge-gray" style="font-size:13px; padding:6px 14px;">{{ $bookings->count() }} total</span>
        </div>
    </div>
</div>

<section style="padding:2.5rem 0;">
    <div class="container">
        @forelse($bookings as $booking)
        <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-lg); overflow:hidden; margin-bottom:1rem; transition:border-color .2s;"
             onmouseover="this.style.borderColor='var(--border-3)'" onmouseout="this.style.borderColor='var(--border-1)'">

            {{-- Top bar --}}
            <div style="display:flex; align-items:center; justify-content:space-between; padding:.875rem 1.25rem; border-bottom:1px solid var(--border-1); background:var(--surface-3);">
                <div style="font-family:var(--font-mono); font-size:13px; color:var(--orange); font-weight:700;">
                    {{ $booking->booking_id }}
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="badge {{ $booking->payment_status==='paid'?'badge-green':($booking->payment_status==='refunded'?'badge-orange':'badge-red') }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                    <span class="badge {{ $booking->status==='confirmed'?'badge-green':'badge-red' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            {{-- Details --}}
            <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:1rem; align-items:center; flex-wrap:wrap;">
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; font-weight:600; margin-bottom:4px;">Movie</div>
                    <div style="font-size:15px; font-weight:700;">{{ $booking->show->movie->title }}</div>
                    <div style="font-size:12px; color:var(--text-3); margin-top:2px;">{{ $booking->show->theater->name }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; font-weight:600; margin-bottom:4px;">Show</div>
                    <div style="font-size:14px; font-weight:600;">{{ $booking->show->show_date->format('d M Y') }}</div>
                    <div style="font-size:13px; color:var(--text-2);">{{ \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A') }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; font-weight:600; margin-bottom:4px;">Seats / Amount</div>
                    <div style="font-size:13px; font-family:var(--font-mono); color:var(--white);">
                        @if(count($booking->active_seats) > 0)
                            <span style="color:var(--green);">{{ implode(', ', $booking->active_seats) }}</span>
                        @endif
                        @if(count($booking->cancelled_seats ?? []) > 0)
                            <span style="color:var(--red); text-decoration:line-through; margin-left:4px;">{{ implode(', ', $booking->cancelled_seats) }}</span>
                        @endif
                    </div>
                    <div style="font-size:15px; font-weight:800; color:var(--orange); margin-top:3px;">Rs. {{ number_format($booking->total_amount) }}</div>
                </div>
                <div>
                    <a href="{{ route('booking.confirm', $booking->id) }}" class="btn btn-primary btn-sm">
                        View Ticket
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center; padding:4rem 0; color:var(--text-3);">
            <div style="font-size:64px; margin-bottom:1rem;">🎟️</div>
            <h3 style="color:var(--text-2); margin-bottom:.5rem;">No bookings yet</h3>
            <p style="margin-bottom:1.5rem;">Start booking your favorite movies!</p>
            <a href="{{ route('movies.index') }}" class="btn btn-primary">Browse Movies</a>
        </div>
        @endforelse
    </div>
</section>

@endsection