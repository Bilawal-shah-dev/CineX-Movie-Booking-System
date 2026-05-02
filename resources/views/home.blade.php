@extends('layouts.app')
@section('title', 'CineX — Book Your Perfect Seat')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="hero" id="hero" style="position:relative; min-height:92vh; display:flex; align-items:center; overflow:hidden; background:#000;">

    {{-- BACKGROUND: CineX Cinema Hall (Image 1) --}}
    <div style="position:absolute; inset:0; z-index:0;">
        <img
            src="{{ asset('images/hero/1-hero.jpg') }}"
            alt="CineX Cinema"
            id="heroBg"
            style="width:100%; height:100%; object-fit:cover; object-position:center top; opacity:.75; transition:opacity 1s;">
        {{-- Main overlay: heavy on left for text, fades right for image --}}
        <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.80) 35%, rgba(0,0,0,0.40) 60%, rgba(0,0,0,0.15) 100%);"></div>
        {{-- Bottom fade to black --}}
        <div style="position:absolute; bottom:0; left:0; right:0; height:220px; background:linear-gradient(to top, #000 0%, transparent 100%);"></div>
        {{-- Red atmospheric glow top-left --}}
        <div style="position:absolute; top:-150px; left:-100px; width:600px; height:600px; background:radial-gradient(circle, rgba(211,47,35,0.18) 0%, transparent 65%); pointer-events:none;"></div>
    </div>

    {{-- CONTENT --}}
    <div style="position:relative; z-index:2; width:100%; padding:0 clamp(1.25rem,4vw,3rem);">
        <div style="display:grid; grid-template-columns:1fr minmax(280px,320px); gap:clamp(1.5rem,4vw,4rem); align-items:center; max-width:1400px; margin:0 auto; padding-top:clamp(80px,10vh,120px); padding-bottom:clamp(60px,8vh,100px);">

            {{-- ===== LEFT: Text ===== --}}
            <div style="min-width:0;">

                {{-- Live Badge --}}
                <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(211,47,35,.12); border:1px solid rgba(211,47,35,.35); border-radius:100px; padding:6px 16px; font-size:11px; font-weight:700; color:#ff6b5b; letter-spacing:.1em; text-transform:uppercase; margin-bottom:clamp(1rem,2vw,1.5rem); animation:fadeSlideLeft .5s ease .1s both;">
                    <span style="width:7px; height:7px; background:var(--red); border-radius:50%; animation:pulse 1.5s ease-in-out infinite; flex-shrink:0;"></span>
                    Live Booking Open
                </div>

                {{-- Heading --}}
                <h1 style="font-size:clamp(42px,6vw,78px); font-weight:900; line-height:1.04; letter-spacing:-.03em; margin-bottom:clamp(1rem,2vw,1.5rem); animation:fadeSlideLeft .5s ease .2s both;">
                    <span style="color:#ffffff; display:block;">Book Your</span>
                    <span style="background:linear-gradient(90deg,#ff3c3c 0%,#ff8c00 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; display:block;">Perfect Seat.</span>
                </h1>

                {{-- Subtitle --}}
                <p style="font-size:clamp(14px,1.5vw,17px); color:rgba(255,255,255,.62); line-height:1.75; max-width:440px; margin-bottom:clamp(1.5rem,3vw,2.25rem); animation:fadeSlideLeft .5s ease .3s both;">
                    Instant cinema ticket booking across Karachi's top theaters.
                    Choose Gold, Platinum, or Box class — from your couch.
                </p>

                {{-- Buttons --}}
                <div style="display:flex; gap:12px; flex-wrap:wrap; animation:fadeSlideLeft .5s ease .4s both;">
                    <a href="{{ route('movies.index') }}"
                       style="display:inline-flex; align-items:center; gap:9px; background:var(--red); color:#fff; padding:13px 26px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; transition:all .25s; box-shadow:0 4px 20px rgba(211,47,35,.45);"
                       onmouseover="this.style.background='#b52a1e';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(211,47,35,.6)'"
                       onmouseout="this.style.background='var(--red)';this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(211,47,35,.45)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        Browse Movies
                    </a>
                    <a href="{{ route('movies.index') }}?status=now_showing"
                       style="display:inline-flex; align-items:center; gap:9px; background:rgba(255,255,255,.06); color:#fff; padding:13px 26px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; border:1px solid rgba(255,255,255,.18); transition:all .25s; backdrop-filter:blur(4px);"
                       onmouseover="this.style.background='rgba(255,255,255,.13)';this.style.borderColor='rgba(255,255,255,.32)'"
                       onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(255,255,255,.18)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/></svg>
                        Now Showing
                    </a>
                </div>

                {{-- Stats Row --}}
<div style="display:flex; align-items:stretch; gap:0; margin-top:clamp(2rem,4vw,3rem); animation:fadeSlideUp .5s ease .5s both; width:fit-content; background:rgba(0,0,0,.45); border:1px solid rgba(255,255,255,.08); border-radius:12px; backdrop-filter:blur(10px); overflow:hidden;">
    @foreach([
        ['🎬', '50+', 'Movies'],
        ['🏢', '3',   'Cinemas'],
        ['💺', '3',   'Seat Classes'],
        ['🎟️', '168', 'Seats Per Show'],
    ] as $i => $st)
    <div style="padding:clamp(10px,1.5vw,16px) clamp(14px,2vw,24px); text-align:center; {{ $i>0?'border-left:1px solid rgba(255,255,255,.07);':'' }} transition:background .2s; cursor:default;"
         onmouseover="this.style.background='rgba(211,47,35,.1)'"
         onmouseout="this.style.background='transparent'">
        <div style="font-size:22px; margin-bottom:5px; filter:sepia(1) saturate(5) hue-rotate(330deg);">{{ $st[0] }}</div>
        <div style="font-size:clamp(16px,2vw,22px); font-weight:900; color:#fff; line-height:1;">{{ $st[1] }}</div>
        <div style="font-size:10px; color:rgba(255,255,255,.4); margin-top:3px; font-weight:500; letter-spacing:.04em; white-space:nowrap;">{{ $st[2] }}</div>
    </div>
    @endforeach
</div>

            </div>

            {{-- ===== RIGHT: Floating Card Slider ===== --}}
            <div style="animation:fadeSlideRight .6s ease .35s both; align-self:center;">

                {{-- Green seats badge --}}
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <div style="display:inline-flex; align-items:center; gap:7px; background:rgba(0,0,0,.65); border:1px solid rgba(0,255,136,.22); border-radius:100px; padding:6px 14px; backdrop-filter:blur(8px); box-shadow:0 0 14px rgba(0,255,136,.12);">
                        <span style="width:7px; height:7px; background:#00ff88; border-radius:50%; box-shadow:0 0 8px rgba(0,255,136,.7); animation:pulse 1.5s ease-in-out infinite; flex-shrink:0;"></span>
                        <span style="font-size:12px; font-weight:700; color:#00ff88; letter-spacing:.04em;">168 Seats Available</span>
                    </div>
                </div>

                {{-- Glassmorphism Slider --}}
                @php
                $hMovies = \App\Models\Movie::where('is_active',true)->take(4)->get();
                $fallImgs = [
                    'https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=600&q=80',
                    'https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?w=600&q=80',
                    'https://images.unsplash.com/photo-1518676590629-3dcbd9c5a5c9?w=600&q=80',
                    'https://images.unsplash.com/photo-1524712245354-2c4e5e7121c0?w=600&q=80',
                ];
                @endphp

                <div style="position:relative; border-radius:20px; overflow:hidden; animation:floatCard 5s ease-in-out infinite; box-shadow:0 32px 80px rgba(0,0,0,.7), 0 0 0 1px rgba(255,255,255,.08);">
                    <div id="heroSlider" style="display:flex; transition:transform .65s cubic-bezier(.4,0,.2,1);">
                        @foreach($hMovies as $idx => $hm)
                        <div style="min-width:100%; flex-shrink:0;">
                            <div style="background:rgba(15,15,15,.75); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,.1); border-radius:20px; overflow:hidden;">

                                {{-- Poster --}}
                                <div style="position:relative; height:180px; overflow:hidden;">
                                    @if($hm->poster_image && file_exists(public_path('images/posters/'.$hm->poster_image)))
    <img src="{{ asset('images/posters/'.$hm->poster_image) }}"
         alt="{{ $hm->title }}" style="width:100%;height:100%;object-fit:cover;">
@else
    <img src="{{ $fallImgs[$idx % 4] }}"
         alt="{{ $hm->title }}" style="width:100%;height:100%;object-fit:cover;">
@endif
                                    <div style="position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.1) 55%,transparent 100%);"></div>
                                    <div style="position:absolute; top:12px; left:12px; background:var(--red); color:#fff; font-size:10px; font-weight:800; padding:4px 10px; border-radius:5px; letter-spacing:.08em; text-transform:uppercase;">
                                        {{ $hm->status === 'now_showing' ? 'Now Showing' : 'Coming Soon' }}
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div style="padding:16px 18px 20px;">
                                    <div style="font-size:11px; font-weight:800; color:var(--orange); letter-spacing:.1em; text-transform:uppercase; margin-bottom:5px;">{{ $hm->genre }}</div>
                                    <div style="font-size:19px; font-weight:900; color:#fff; margin-bottom:10px; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $hm->title }}</div>
                                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
                                        <div style="display:flex; align-items:center; gap:5px;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#ffc107"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                            <span style="font-size:14px; font-weight:700; color:#fff;">{{ number_format($hm->avg_rating,1) }}</span>
                                        </div>
                                        <span style="color:rgba(255,255,255,.25);">•</span>
                                        <span style="font-size:12px; color:rgba(255,255,255,.5);">{{ $hm->duration_minutes }}m</span>
                                    </div>
                                    <a href="{{ route('movies.show',$hm->id) }}"
                                       style="display:flex; align-items:center; justify-content:center; gap:8px; width:100%; background:var(--red); color:#fff; padding:11px; border-radius:9px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; box-shadow:0 4px 16px rgba(211,47,35,.4);"
                                       onmouseover="this.style.background='#b52a1e';this.style.boxShadow='0 6px 24px rgba(211,47,35,.6)'"
                                       onmouseout="this.style.background='var(--red)';this.style.boxShadow='0 4px 16px rgba(211,47,35,.4)'">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Dots --}}
                    <div id="sliderDots" style="display:flex; justify-content:center; gap:6px; padding:12px 0 4px; background:transparent;">
                        @foreach($hMovies as $idx => $hm)
                        <div class="sdot" data-idx="{{ $idx }}"
                             style="width:{{ $idx===0?'22px':'7px' }}; height:7px; border-radius:100px; background:{{ $idx===0?'var(--red)':'rgba(255,255,255,.25)' }}; transition:all .35s; cursor:pointer;"></div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Keyframes --}}
    <style>
    @keyframes fadeSlideLeft  { from{opacity:0;transform:translateX(-28px)} to{opacity:1;transform:translateX(0)} }
    @keyframes fadeSlideRight { from{opacity:0;transform:translateX(28px)}  to{opacity:1;transform:translateX(0)} }
    @keyframes fadeSlideUp    { from{opacity:0;transform:translateY(18px)}  to{opacity:1;transform:translateY(0)} }
    @keyframes floatCard      { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-9px)} }

    /* Responsive */
    @media(max-width:900px){
        #hero .hero-right-col { display:none !important; }
        #hero [style*="grid-template-columns"] { grid-template-columns:1fr !important; }
    }
    @media(max-width:520px){
        #hero h1 { font-size:38px !important; }
        #hero p  { font-size:14px !important; max-width:100% !important; }
    }
    </style>
</section>

@push('scripts')
<script>
(function(){
    var slider = document.getElementById('heroSlider');
    var dots   = document.querySelectorAll('.sdot');
    if(!slider||!dots.length) return;
    var cur=0, tot=dots.length;
    function goTo(n){
        cur=n;
        slider.style.transform='translateX(-'+(100*n)+'%)';
        dots.forEach(function(d,i){
            d.style.width      = i===n?'22px':'7px';
            d.style.background = i===n?'var(--red)':'rgba(255,255,255,.25)';
        });
    }
    dots.forEach(function(d){ d.addEventListener('click',function(){ goTo(+d.dataset.idx); }); });
    setInterval(function(){ goTo((cur+1)%tot); }, 3500);
})();
</script>
@endpush

{{-- ===================== GENRE FILTER BAR ===================== --}}
<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); border-top:1px solid var(--border-1);">
    <div class="container">
        <div style="display:flex; gap:8px; padding:14px 0; overflow-x:auto; scrollbar-width:none; -ms-overflow-style:none;">
            @foreach(['All','Action','Thriller','Drama','Comedy','Romance','Horror','Animation'] as $g)
<a href="{{ $g === 'All' ? route('movies.index') : route('movies.index').'?genre='.$g }}"
   class="genre-pill {{ (request('genre')===$g || ($g==='All' && !request('genre'))) ? 'active' : '' }}">
    {{ $g }}
</a>
@endforeach
        </div>
    </div>
</div>

{{-- ===================== NOW SHOWING ===================== --}}
@if($nowShowing->count())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Now Showing</h2>
            <a href="{{ route('movies.index') }}?status=now_showing" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="grid-movies">
            @foreach($nowShowing as $movie)
                @include('partials.movie-card', ['movie' => $movie])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===================== COMING SOON ===================== --}}
@if($comingSoon->count())
<section class="section" style="background:var(--surface-1); border-top:1px solid var(--border-1); border-bottom:1px solid var(--border-1);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Coming Soon</h2>
            <a href="{{ route('movies.index') }}?status=coming_soon" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="grid-movies">
            @foreach($comingSoon as $movie)
                @include('partials.movie-card', ['movie' => $movie])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===================== HOW IT WORKS ===================== --}}
<section class="section">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <h2 style="font-size:32px; font-weight:900; margin-bottom:.75rem;">How It Works</h2>
            <p style="color:var(--text-3); font-size:15px; max-width:400px; margin:0 auto;">
                Four simple steps to your perfect movie experience
            </p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1.5rem;">

            @php
            $steps = [
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="3"/><path d="m9 9 3 3 3-3"/><path d="M12 12v6"/></svg>',
                 'title' => 'Browse Movies', 'desc' => 'Explore movies by genre, rating, or search by title', 'color' => 'var(--red)'],
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
                 'title' => 'Select Show', 'desc' => 'Pick your preferred date and show timing', 'color' => 'var(--orange)'],
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/><path d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"/></svg>',
                 'title' => 'Pick Your Seat', 'desc' => 'Choose from Gold, Platinum or Box class seats', 'color' => '#378ADD'],
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                 'title' => 'Get Ticket', 'desc' => 'Pay online and receive your ticket via email instantly', 'color' => 'var(--green)'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-lg); padding:2rem 1.5rem; position:relative; overflow:hidden; transition:border-color .2s, transform .2s;"
                 onmouseover="this.style.borderColor='{{ $step['color'] }}'; this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='var(--border-1)'; this.style.transform='translateY(0)'">

                {{-- Step number bg --}}
                <div style="position:absolute; top:12px; right:16px; font-size:64px; font-weight:900; color:rgba(255,255,255,0.03); line-height:1; font-family:var(--font-heading);">{{ $i+1 }}</div>

                <div style="width:52px; height:52px; border-radius:var(--radius-md); background:rgba(0,0,0,.4); border:1px solid var(--border-2); display:flex; align-items:center; justify-content:center; color:{{ $step['color'] }}; margin-bottom:1.25rem;">
                    {!! $step['icon'] !!}
                </div>

                <div style="width:24px; height:24px; background:{{ $step['color'] }}; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; color:white; margin-bottom:.75rem;">{{ $i+1 }}</div>

                <h4 style="font-size:16px; font-weight:700; margin-bottom:.5rem; color:var(--white);">{{ $step['title'] }}</h4>
                <p style="font-size:13px; color:var(--text-3); line-height:1.65;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== SEAT CLASSES ===================== --}}
<section class="section" style="background:var(--surface-1); border-top:1px solid var(--border-1); border-bottom:1px solid var(--border-1);">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <h2 style="font-size:32px; font-weight:900; margin-bottom:.75rem;">Choose Your Class</h2>
            <p style="color:var(--text-3); font-size:15px;">Three seating categories to match your comfort and budget</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem;">
            @foreach([
                ['Gold', 'Rs. 800', '#EF9F27', '#1a1000', '#633806', 'Rows F–L', 'Standard comfortable seating with great views of the screen.', ['Comfortable seating','Good screen visibility','Standard legroom']],
                ['Platinum', 'Rs. 1,200', '#378ADD', '#00101a', '#0c447c', 'Rows C–E', 'Premium reclinable seats in the center zone for the best experience.', ['Wider seats','Premium legroom','Center zone']],
                ['Box Class', 'Rs. 2,000', '#7F77DD', '#100010', '#3C3489', 'Rows A–B', 'Exclusive front box seating — the most luxurious cinema experience.', ['Exclusive section','Maximum privacy','Luxury seating']],
            ] as $class)
            <div style="background:{{ $class[3] }}; border:1px solid {{ $class[4] }}; border-radius:var(--radius-lg); padding:1.75rem; text-align:center;">
                <div style="font-size:13px; font-weight:800; color:{{ $class[2] }}; letter-spacing:.1em; text-transform:uppercase; margin-bottom:.5rem;">{{ $class[5] }}</div>
                <div style="font-size:22px; font-weight:900; color:{{ $class[2] }}; margin-bottom:.25rem;">{{ $class[0] }}</div>
                <div style="font-size:28px; font-weight:900; color:var(--white); margin-bottom:.75rem;">{{ $class[1] }}</div>
                <p style="font-size:13px; color:var(--text-2); margin-bottom:1.25rem; line-height:1.6;">{{ $class[6] }}</p>
                <div style="display:flex; flex-direction:column; gap:6px; text-align:left;">
                    @foreach($class[7] as $feat)
                    <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:var(--text-2);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $class[2] }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="section">
    <div class="container">
        <div style="background:linear-gradient(135deg, #1a0000 0%, #0d0000 50%, #1a0500 100%); border:1px solid rgba(211,47,35,.25); border-radius:var(--radius-xl); padding:4rem 3rem; text-align:center; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; background:radial-gradient(circle, rgba(211,47,35,.12) 0%, transparent 65%); pointer-events:none;"></div>
            <div style="position:relative; z-index:1;">
                <h2 style="font-size:36px; font-weight:900; margin-bottom:.75rem;">Ready to Watch?</h2>
                <p style="color:var(--text-2); font-size:16px; margin-bottom:2rem; max-width:420px; margin-left:auto; margin-right:auto;">
                    Book your seats now before they sell out. Best seats go fast!
                </p>
                <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                    <a href="{{ route('movies.index') }}" class="btn btn-primary btn-lg">Book Now</a>
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-outline btn-lg">Create Account</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

@endsection