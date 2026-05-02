@extends('layouts.app')
@section('title', 'Terms of Use — CineX')
@section('content')
<div style="padding:3rem 0;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:36px;font-weight:900;margin-bottom:.5rem;">Terms of <span class="text-red">Use</span></h1>
        <p style="color:var(--text-3);font-size:13px;">Last updated: April 2026</p>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:780px;">
        @php $sections = [
            ['1. Acceptance of Terms','By accessing CineX, you agree to these terms. If you disagree, please do not use the platform.'],
            ['2. Use of Service','CineX is an online cinema ticket booking platform. You must be 13+ to create an account. You are responsible for keeping your login credentials secure.'],
            ['3. Booking & Payment','All bookings are subject to seat availability. Prices are set by theater management and may vary. Payment must be completed to confirm a booking.'],
            ['4. Cancellation Policy','Bookings may be cancelled up to 1 hour before show time. Refunds are processed within 3-5 business days to the original payment method.'],
            ['5. Kids Discount','Children aged 3-12 qualify for 50% discount. Ages must be accurate at the time of booking.'],
            ['6. Ticket Usage','Tickets are non-transferable. Present your booking ID at the cinema. CineX is not responsible for lost or stolen tickets.'],
            ['7. Prohibited Activities','You may not: book tickets for resale, use automated bots, provide false information, or abuse the cancellation system.'],
            ['8. Limitation of Liability','CineX is a demonstration project built for educational purposes (Aptech eProject). No real financial transactions occur.'],
            ['9. Contact','For queries: support@cinex.pk'],
        ]; @endphp
        @foreach($sections as $s)
        <div style="margin-bottom:2rem;">
            <h2 style="font-size:18px;font-weight:800;color:var(--white);margin-bottom:.75rem;">{{ $s[0] }}</h2>
            <p style="color:var(--text-2);font-size:14px;line-height:1.8;">{{ $s[1] }}</p>
        </div>
        @if(!$loop->last)<div style="border-top:1px solid var(--border-1);margin-bottom:2rem;"></div>@endif
        @endforeach
    </div>
</section>
@endsection