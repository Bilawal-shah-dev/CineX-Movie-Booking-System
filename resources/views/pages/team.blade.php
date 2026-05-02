@extends('layouts.app')
@section('title', 'Our Team — CineX')
@section('content')

<div style="padding:4rem 0 3rem;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:clamp(28px,4vw,44px);font-weight:900;margin-bottom:.75rem;">Meet the <span class="text-red">Team</span></h1>
        <p style="color:var(--text-3);font-size:15px;max-width:500px;margin:0 auto;">
            The passionate developers behind CineX — built as part of the Aptech eProject program.
        </p>
    </div>
</div>

<section class="section">
    <div class="container">

        {{-- Project Info --}}
        <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:2rem;margin-bottom:3rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1.25rem;text-align:center;">
            @foreach([
                ['📁','Project','Online Movie Booking System'],
                ['🏫','Institute','Aptech Computer Education, Johar'], 
                ['📅','Semester','Semester 2'],
                ['⏱','Duration','25 Apr — 25 May 2026'],
                ['💻','Stack','PHP · Laravel · MySQL'],
            ] as $i)
            <div>
                <div style="font-size:22px;margin-bottom:6px;">{{ $i[0] }}</div>
                <div style="font-size:10px;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;font-weight:700;">{{ $i[1] }}</div>
                <div style="font-size:13px;font-weight:600;color:var(--white);">{{ $i[2] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Team Members --}}
        <h2 class="section-title" style="margin-bottom:2rem;">Development Team</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.5rem;">
            @php
$team = [
    ['SB', 'Syed Muhammad Bilawal Ali', 'Student1553322',
     'Full Stack Developer (Lead)',
     'Led overall system development including frontend UI, Laravel backend architecture, core functionality, and full project integration.',
     'bilawalshah78924@gmail.com'],

    ['AK', 'Ayan Mujtaba Khan', 'Student1634806',
     'Backend Support',
     'Assisted in backend structure, database setup, and application support tasks.',
     'ayanmujtabakhan90@gmail.com'],

    ['HK', 'Haseeba Kausar', 'Student1654000',
     'Documentation & Reports',
     'Prepared complete project documentation, eProject reports, user guide, and assisted in requirement structuring.',
     'haseebakausar92@gmail.com'],

    ['SM', 'Shahid Manzar', 'Student1654030',
     'Database Support & QA',
     'Supported testing process, reviewed system flows and usability, and provided assistance in database-related tasks and structure review.',
     'ssmanzar1@gmail.com'],
];
$colors = ['var(--red)','#378ADD','var(--orange)','var(--green)'];
@endphp

            @foreach($team as $i => $m)
            <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:1.75rem;text-align:center;transition:border-color .2s,transform .2s;"
                 onmouseover="this.style.borderColor='{{ $colors[$i] }}';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='var(--border-1)';this.style.transform='none'">
                <div style="width:68px;height:68px;margin:0 auto 1rem;">
                    <img src="{{ asset('images/team/' . $m[0]) }}"
                       alt="{{ $m[1] }}"
                       style="width:100%;height:100%;object-fit:cover;border-radius:50%;border:3px solid {{ $colors[$i] }};">
                    </div>
                <div style="font-size:16px;font-weight:800;margin-bottom:3px;">{{ $m[1] }}</div>
                <div style="font-size:11px;color:{{ $colors[$i] }};font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">{{ $m[3] }}</div>
                <div style="font-size:11px;color:var(--text-3);margin-bottom:8px;font-family:var(--font-mono);">{{ $m[2] }}</div>
                <div style="font-size:12px;color:var(--text-2);line-height:1.5;margin-bottom:10px;">{{ $m[4] }}</div>
                @if($m[5])
                <a href="mailto:{{ $m[5] }}" style="font-size:11px;color:var(--text-3);text-decoration:none;display:block;"
                   onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--text-3)'">
                    {{ $m[5] }}
                </a>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Supervisor --}}
        <div style="background:linear-gradient(135deg,#0d0000,#1a0000);border:1px solid rgba(211,47,35,.2);border-radius:var(--radius-lg);padding:2rem;margin-top:2rem;text-align:center;">
            <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;letter-spacing:.1em;font-weight:700;margin-bottom:.5rem;">Project Supervisor</div>
            <div style="font-size:18px;font-weight:800;margin-bottom:4px;">Aptech eProjects Team</div>
            
            <div style="font-size:12px;color:var(--text-3);margin-top:4px;">Aptech Computer Education — Johar Campus (JHR)</div>
        </div>

        {{-- Technology Stack --}}
        <div style="margin-top:3rem;">
            <h2 class="section-title" style="margin-bottom:1.5rem;">Technology Stack</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;">
                @foreach([
                    ['🐘','PHP 8.2','Backend Language'],
                    ['🚀','Laravel 12','PHP Framework'],
                    ['🗃️','MySQL','Relational Database'],
                    ['🎨','Bootstrap 5','CSS Framework'],
                    ['⚡','JavaScript','Frontend Logic'],
                    ['🖼️','Blade','Templating Engine'],
                    ['📧','Laravel Mail','Email System'],
                    ['🔒','Breeze Auth','Authentication'],
                ] as $t)
                <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1rem;text-align:center;">
                    <div style="font-size:26px;margin-bottom:6px;">{{ $t[0] }}</div>
                    <div style="font-size:13px;font-weight:700;color:var(--white);">{{ $t[1] }}</div>
                    <div style="font-size:11px;color:var(--text-3);margin-top:2px;">{{ $t[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endsection