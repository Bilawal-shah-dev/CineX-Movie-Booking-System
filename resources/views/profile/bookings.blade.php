@extends('layouts.app')
@section('title', 'My Bookings — CineX')

@section('content')
<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); padding:2rem 0;">
    <div class="container">
        <h1 style="font-size:28px; font-weight:800;">My Bookings</h1>
        <p style="color:var(--text-3); margin-top:6px;">Aapki saari ticket bookings</p>
    </div>
</div>

<section class="section">
    <div class="container">
        @forelse($bookings as $booking)
        <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-lg); overflow:hidden; margin-bottom:1rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem; border-bottom:1px solid var(--border-1);">
                <div style="font-family:var(--font-mono); font-size:13px; color:var(--orange);">
                    {{ $booking->booking_id }}
                </div>
                <span class="badge {{ $booking->payment_status === 'paid' ? 'badge-green' : 'badge-orange' }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </div>
            <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem;">
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Movie</div>
                    <div style="font-size:15px; font-weight:700;">{{ $booking->show->movie->title }}</div>
                    <div style="font-size:12px; color:var(--text-3); margin-top:2px;">{{ $booking->show->theater->name }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Show</div>
                    <div style="font-size:14px; font-weight:600;">{{ $booking->show->show_date->format('d M Y') }}</div>
                    <div style="font-size:13px; color:var(--text-2);">{{ \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A') }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Seats / Amount</div>
                    <div style="font-size:14px; font-weight:600;">{{ implode(', ', $booking->seat_numbers) }}</div>
                    <div style="font-size:15px; font-weight:700; color:var(--orange);">Rs. {{ number_format($booking->total_amount) }}</div>
                </div>
            </div>
        </div>
        {{-- Cancel option --}}
    @php 
     $sdt = \Carbon\Carbon::parse($booking->show->show_date->format('Y-m-d').' '.$booking->show->show_time);
     $canCancel = now()->diffInMinutes($sdt, false) > 60 && $booking->status === 'confirmed';
     @endphp
     @if($canCancel)
      <form method="POST" action="{{ route('booking.cancel', $booking->id) }}"
          onsubmit="return confirm('Cancel this booking?')" style="margin-top:8px;">
        @csrf
        @method('PATCH')
        <button type="submit"
            style="background:transparent; border:1px solid rgba(211,47,35,.3); color:var(--red); padding:5px 12px; border-radius:5px; font-size:11px; font-weight:700; cursor:pointer; font-family:var(--font-body); transition:all .2s;"
            onmouseover="this.style.background='rgba(211,47,35,.1)'"
            onmouseout="this.style.background='transparent'">
            Cancel Booking
        </button>
      </form>
     @elseif($booking->status === 'cancelled')
     <span style="font-size:11px; color:var(--red); font-weight:600; margin-top:6px; display:block;">✕ Cancelled</span>
     @endif
     
        @empty
            <div style="text-align:center; padding:4rem 0; color:var(--text-3);">
                <div style="font-size:64px; margin-bottom:1rem;">&#127915;</div>
                <h3 style="color:var(--text-2); margin-bottom:.5rem;">Koi booking nahi</h3>
                <p style="margin-bottom:1.5rem;">Abhi tak koi ticket book nahi ki.</p>
                <a href="{{ route('movies.index') }}" class="btn btn-primary">Browse Movies</a>
            </div>
        @endforelse
    </div>
    
</section>
@endsection

{{-- Previous version with profile sidebar and recent bookings summary --}}