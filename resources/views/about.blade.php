@extends('layouts.app')
@section('title', 'About Us — CineX')

@section('content')

{{-- Hero --}}
<div style="position:relative;overflow:hidden;background:var(--black);padding:5rem 0 4rem;border-bottom:1px solid var(--border-1);">
    <div style="position:absolute;inset:0;">
        <img src="{{ asset('images/hero/cinema-bg.jpg') }}" alt="" style="width:100%;height:100%;object-fit:cover;opacity:.12;filter:blur(4px);">
        <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.92),rgba(20,0,0,.88));"></div>
    </div>
    <div class="container" style="position:relative;z-index:1;text-align:center;">
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(211,47,35,.1);border:1px solid rgba(211,47,35,.3);border-radius:100px;padding:5px 16px;font-size:11px;font-weight:700;color:var(--red);letter-spacing:.1em;text-transform:uppercase;margin-bottom:1.25rem;">
            Our Story
        </div>
        <h1 style="font-size:clamp(32px,5vw,52px);font-weight:900;margin-bottom:1rem;line-height:1.1;">
            Redefining the<br><span style="color:var(--red);">Cinema Experience</span>
        </h1>
        <p style="font-size:16px;color:var(--text-2);max-width:540px;margin:0 auto;line-height:1.75;">
            CineX was built with one mission: to make movie booking as magical as the films themselves.
        </p>
    </div>
</div>

{{-- Mission --}}
<section style="padding:5rem 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">
            <div>
                <h2 style="font-size:34px;font-weight:900;margin-bottom:1rem;">Why We Built CineX</h2>
                <p style="color:var(--text-2);line-height:1.8;margin-bottom:1rem;font-size:15px;">
                    Long queues, sold-out shows, no seat visibility — going to the cinema in Pakistan had become a frustrating experience. We knew technology could fix this.
                </p>
                <p style="color:var(--text-2);line-height:1.8;margin-bottom:1.5rem;font-size:15px;">
                    CineX was created by a team of passionate developers and cinema lovers from Karachi. Our platform brings the entire cinema experience — from browsing movies to printing your ticket — into one seamless digital journey.
                </p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach([
                        ['🎬','Instant seat selection with real-time availability'],
                        ['💳','Secure payment via JazzCash, EasyPaisa & Card'],
                        ['📧','Instant confirmation tickets via email'],
                        ['📱','Fully responsive — works on any device'],
                    ] as $f)
                    <div style="display:flex;align-items:center;gap:12px;font-size:14px;color:var(--text-2);">
                        <span style="font-size:20px;">{{ $f[0] }}</span>{{ $f[1] }}
                    </div>
                    @endforeach
                </div>
            </div>
            <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-xl);padding:2.5rem;text-align:center;">
                <div style="font-size:64px;font-weight:900;color:var(--red);line-height:1;">CINE<span style="color:var(--orange);">X</span></div>
                <div style="font-size:14px;color:var(--text-3);margin-top:8px;letter-spacing:.08em;text-transform:uppercase;">Cinema Booking Platform</div>
                <div style="border-top:1px solid var(--border-1);margin:1.5rem 0;"></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    @foreach([
                        ['50+','Movies Listed'],
                        ['3','Premium Cinemas'],
                        ['168','Seats Per Show'],
                        ['3','Seat Classes'],
                    ] as $s)
                    <div style="background:var(--surface-3);border-radius:var(--radius-sm);padding:1rem;">
                        <div style="font-size:26px;font-weight:900;color:var(--red);">{{ $s[0] }}</div>
                        <div style="font-size:11px;color:var(--text-3);margin-top:3px;">{{ $s[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section style="padding:4rem 0;background:var(--surface-1);border-top:1px solid var(--border-1);border-bottom:1px solid var(--border-1);">
    <div class="container">
        <div style="text-align:center;margin-bottom:3rem;">
            <h2 style="font-size:32px;font-weight:900;margin-bottom:.75rem;">Our Core Values</h2>
            <p style="color:var(--text-3);font-size:15px;">What drives everything we do at CineX</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
            @foreach([
                ['🎯','Customer First','Every feature we build starts with the question: does this make the user experience better?'],
                ['🔒','Trust & Security','Your payment and personal data are handled with the highest standards of security.'],
                ['⚡','Speed & Reliability','Fast load times and 99.9% uptime — because your movie night can\'t wait.'],
                ['🌟','Innovation','We continuously push the boundaries of what a cinema booking platform can be.'],
            ] as $v)
            <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:1.75rem;transition:border-color .2s,transform .2s;"
                 onmouseover="this.style.borderColor='var(--red)';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='var(--border-1)';this.style.transform='none'">
                <div style="font-size:36px;margin-bottom:1rem;">{{ $v[0] }}</div>
                <h4 style="font-size:16px;font-weight:700;margin-bottom:.5rem;">{{ $v[1] }}</h4>
                <p style="font-size:13px;color:var(--text-3);line-height:1.65;">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:4rem 0;">
    <div class="container">
        <div style="background:linear-gradient(135deg,#1a0000,#0d0000);border:1px solid rgba(211,47,35,.2);border-radius:var(--radius-xl);padding:3.5rem;text-align:center;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(211,47,35,.1),transparent 70%);pointer-events:none;"></div>
            <h2 style="font-size:32px;font-weight:900;margin-bottom:.75rem;">Ready to Experience CineX?</h2>
            <p style="color:var(--text-2);font-size:15px;margin-bottom:2rem;max-width:400px;margin-left:auto;margin-right:auto;">
                Join thousands of movie lovers who book smarter with CineX.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('movies.index') }}" class="btn btn-primary btn-lg">Browse Movies</a>
                @guest
                <a href="{{ route('register') }}" class="btn btn-outline btn-lg">Create Account</a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection