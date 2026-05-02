@extends('layouts.app')
@section('title', 'FAQ — CineX')
@section('content')

<div style="padding:3.5rem 0 3rem;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:clamp(28px,4vw,42px);font-weight:900;margin-bottom:.75rem;">Frequently Asked <span class="text-red">Questions</span></h1>
        <p style="color:var(--text-3);font-size:15px;max-width:480px;margin:0 auto;">Everything you need to know about booking tickets on CineX.</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:800px;">
        @php
        $faqs = [
            ['Booking','How do I book a ticket?','Browse movies → Click on a movie → Click Book Now → Select show time → Choose seats → Pay → Done! Your confirmation email will arrive instantly.'],
            ['Booking','Can I book multiple seats?','Yes! On the seat selection page, click multiple seats to select them. The total price updates automatically.'],
            ['Booking','What are the seat classes?','Gold (Rs.800) — Rows F to L, standard comfortable seating. Platinum (Rs.1,200) — Rows C to E, premium center zone. Box Class (Rs.2,000) — Rows A to B, exclusive front section.'],
            ['Booking','Is there a kids discount?','Yes! Children aged 3–12 get 50% off. Select the number of kids when choosing seats.'],
            ['Payment','What payment methods are accepted?','JazzCash, EasyPaisa, and Debit/Credit Card. All payments are processed securely.'],
            ['Payment','Is my payment information safe?','Yes. This is a demo system — no real transactions occur. In production, all payments would be encrypted with SSL.'],
            ['Cancellation','Can I cancel my booking?','Yes, up to 1 hour before show time. Go to My Bookings → View Ticket → Cancel Seats. Refund processes in 3–5 business days.'],
            ['Cancellation','Can I cancel individual seats?','Yes! You can cancel specific seats from your booking while keeping others active.'],
            ['Tickets','How do I get my ticket?','After payment, a confirmation email is sent. You can also print your ticket from the booking confirmation page.'],
            ['Account','Do I need an account to book?','Yes. Creating an account is free and takes less than a minute.'],
        ];
        $categories = array_unique(array_column($faqs, 0));
        @endphp

        @foreach($categories as $cat)
        <div style="margin-bottom:2.5rem;">
            <h2 style="font-size:18px;font-weight:800;color:var(--red);margin-bottom:1rem;padding-bottom:.5rem;border-bottom:1px solid var(--border-1);">{{ $cat }}</h2>
            @foreach($faqs as $faq)
                @if($faq[0] === $cat)
                <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;">
                    <button onclick="this.parentElement.classList.toggle('faq-open')"
                        style="width:100%;background:none;border:none;padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;cursor:pointer;font-family:var(--font-body);text-align:left;">
                        <span style="font-size:14px;font-weight:600;color:var(--white);">{{ $faq[1] }}</span>
                        <span style="color:var(--red);font-size:18px;flex-shrink:0;margin-left:10px;transition:transform .2s;" class="faq-icon">+</span>
                    </button>
                    <div style="display:none;padding:0 1.25rem 1rem;" class="faq-answer">
                        <p style="font-size:14px;color:var(--text-2);line-height:1.7;">{{ $faq[2] }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endforeach

        <div style="background:linear-gradient(135deg,#0d0000,#1a0000);border:1px solid rgba(211,47,35,.2);border-radius:var(--radius-lg);padding:2rem;text-align:center;margin-top:2rem;">
            <h3 style="font-size:18px;font-weight:700;margin-bottom:.5rem;">Still have questions?</h3>
            <p style="color:var(--text-3);font-size:14px;margin-bottom:1.25rem;">Our support team is here to help.</p>
            <a href="{{ route('pages.contact') }}" class="btn btn-primary">Contact Us</a>
        </div>
    </div>
</section>

<style>
.faq-open .faq-icon { transform: rotate(45deg); }
.faq-open .faq-answer { display: block !important; }
</style>
@endsection