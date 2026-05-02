@extends('layouts.app')
@section('title', 'Careers — CineX')
@section('content')
<div style="padding:3.5rem 0 3rem;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:clamp(28px,4vw,42px);font-weight:900;margin-bottom:.75rem;">Join the <span class="text-red">CineX</span> Team</h1>
        <p style="color:var(--text-3);font-size:15px;">Help us build the future of cinema booking in Pakistan.</p>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;margin-bottom:3rem;">
            @foreach([
                ['💻','Full Stack Developer','Laravel · PHP · MySQL · Vue.js','Build and maintain the CineX booking platform. Work on new features, API integrations, and performance improvements.','Full Time'],
                ['🎨','UI/UX Designer','Figma · CSS · Design Systems','Design beautiful, accessible cinema booking experiences. Create the visual language that millions will interact with.','Full Time'],
                ['📱','Mobile Developer','React Native · Flutter','Build the CineX mobile app for iOS and Android — bringing cinema booking to everyone\'s pocket.','Full Time'],
                ['📊','Data Analyst','SQL · Python · Tableau','Analyze booking trends, cinema performance, and user behavior to drive product decisions.','Part Time'],
            ] as $j)
            <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:1.75rem;transition:border-color .2s,transform .2s;"
                 onmouseover="this.style.borderColor='var(--red)';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='var(--border-1)';this.style.transform='none'">
                <div style="font-size:32px;margin-bottom:.75rem;">{{ $j[0] }}</div>
                <h3 style="font-size:17px;font-weight:800;margin-bottom:4px;">{{ $j[1] }}</h3>
                <div style="font-size:11px;color:var(--orange);font-weight:600;margin-bottom:.75rem;letter-spacing:.04em;">{{ $j[2] }}</div>
                <p style="font-size:13px;color:var(--text-3);line-height:1.65;margin-bottom:1rem;">{{ $j[3] }}</p>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span style="background:rgba(40,167,69,.1);border:1px solid rgba(40,167,69,.25);color:var(--green);font-size:11px;font-weight:700;padding:4px 10px;border-radius:5px;">{{ $j[4] }}</span>
                    <a href="{{ route('pages.contact') }}" class="btn btn-primary btn-sm">Apply Now</a>
                </div>
            </div>
            @endforeach
        </div>

        <div style="background:linear-gradient(135deg,#0d0000,#1a0000);border:1px solid rgba(211,47,35,.2);border-radius:var(--radius-xl);padding:3rem;text-align:center;">
            <h2 style="font-size:26px;font-weight:900;margin-bottom:.75rem;">Don't see your role?</h2>
            <p style="color:var(--text-2);font-size:15px;margin-bottom:1.5rem;max-width:420px;margin-left:auto;margin-right:auto;">We're always looking for talented people. Send us your CV and we'll keep you in mind.</p>
            <a href="mailto:careers@cinex.pk" class="btn btn-primary">Send Your CV</a>
        </div>
    </div>
</section>
@endsection