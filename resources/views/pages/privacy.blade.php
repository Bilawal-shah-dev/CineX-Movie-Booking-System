@extends('layouts.app')
@section('title', 'Privacy Policy — CineX')
@section('content')
<div style="padding:3rem 0;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:36px;font-weight:900;margin-bottom:.5rem;">Privacy <span class="text-red">Policy</span></h1>
        <p style="color:var(--text-3);font-size:13px;">Last updated: April 2026</p>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:780px;">
        @php $sections = [
            ['Information We Collect','We collect: name, email address, phone number, booking history, and payment method type (not card numbers). We do not store actual payment credentials.'],
            ['How We Use Your Information','Your information is used to: process bookings, send confirmation emails, provide customer support, and improve our platform.'],
            ['Data Security','All data is stored securely. Passwords are encrypted using bcrypt. Session data is protected with CSRF tokens.'],
            ['Cookies','We use session cookies to maintain your login state. No third-party tracking cookies are used.'],
            ['Data Sharing','We do not sell, trade, or share your personal information with third parties, except as required by law.'],
            ['Your Rights','You may request deletion of your account and data by contacting support@cinex.pk'],
            ['Children\'s Privacy','CineX is not directed to children under 13. We do not knowingly collect data from children under 13.'],
            ['Changes to Policy','We may update this policy. Changes will be posted on this page with an updated date.'],
            ['Contact','Privacy questions: support@cinex.pk'],
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