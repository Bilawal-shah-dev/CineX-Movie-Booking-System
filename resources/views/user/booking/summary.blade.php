@extends('layouts.app')
@section('title', 'Booking Summary — CineX')

@section('content')
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; padding:2rem 1rem; background:radial-gradient(ellipse at 50% 0%, rgba(211,47,35,.07) 0%, transparent 60%);">
    <div style="width:100%; max-width:520px;">

        <div style="text-align:center; margin-bottom:2rem;">
            <h1 style="font-size:26px; font-weight:800; margin-bottom:6px;">Booking Summary</h1>
            <p style="color:var(--text-3); font-size:14px;">Review your selection before payment</p>
        </div>

        <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-lg); overflow:hidden; margin-bottom:1.5rem;">

            {{-- Header --}}
            <div style="background:var(--red); padding:1.25rem 1.5rem; display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <div style="font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; opacity:.8;">Movie</div>
                    <div style="font-size:18px; font-weight:800; margin-top:2px;">{{ $show->movie->title }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:11px; opacity:.8; text-transform:uppercase; letter-spacing:.06em;">Theater</div>
                    <div style="font-size:14px; font-weight:600; margin-top:2px;">{{ $show->theater->name }}</div>
                </div>
            </div>

            {{-- Details --}}
            <div style="padding:1.5rem;">
                @foreach([
                    ['Date', $show->show_date->format('l, d M Y')],
                    ['Time', \Carbon\Carbon::parse($show->show_time)->format('h:i A')],
                    ['Seat Class', ucfirst($seatClass)],
                    ['Seats', implode(', ', $seatNumbers)],
                    ['Total Seats', $numSeats],
                    ['Kids (50% off)', $kidsCount],
                    ['Price per seat', 'Rs. ' . number_format($unitPrice)],
                ] as $row)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid var(--border-1); font-size:14px;">
                    <span style="color:var(--text-3);">{{ $row[0] }}</span>
                    <span style="font-weight:600; color:var(--white);">{{ $row[1] }}</span>
                </div>
                @endforeach

                {{-- Total --}}
                <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0 0; font-size:17px;">
                    <span style="font-weight:700;">Total Amount</span>
                    <span style="font-weight:900; color:var(--orange); font-size:22px;">Rs. {{ number_format($totalAmount) }}</span>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('booking.seats', $show->id) }}" class="btn btn-outline" style="flex:1; text-align:center;">← Change Seats</a>
            <a href="{{ route('payment.index') }}" class="btn btn-primary" style="flex:2; text-align:center; font-size:15px;">
                Proceed to Payment →
            </a>
        </div>
    </div>
</div>
@endsection