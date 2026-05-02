@extends('layouts.app')
@section('title', $movie->title . ' — CineX')

@section('content')

{{-- MOVIE HERO --}}
<div style="position:relative; overflow:hidden; background:var(--black);">

    {{-- Blurred poster bg --}}
    <div style="position:absolute; inset:0; z-index:0;">
        @if($movie->poster_image)
            <img src="{{ asset('images/posters/'.$movie->poster_image) }}"
                 style="width:100%; height:100%; object-fit:cover; filter:blur(40px) brightness(.25); transform:scale(1.1);" alt="">
        @else
            <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a0000,#0d0000);"></div>
        @endif
        <div style="position:absolute; inset:0; background:linear-gradient(to bottom, rgba(0,0,0,.5) 0%, rgba(0,0,0,.85) 70%, #000 100%);"></div>
    </div>

    <div class="container" style="position:relative; z-index:1; padding-top:3rem; padding-bottom:3rem;">
        <div style="display:grid; grid-template-columns:220px 1fr; gap:2.5rem; align-items:start;">

            {{-- Poster --}}
            <div style="border-radius:var(--radius-lg); overflow:hidden; border:1px solid rgba(255,255,255,.1); box-shadow:0 24px 60px rgba(0,0,0,.6); flex-shrink:0;">
                @if($movie->poster_image && file_exists(public_path('images/posters/'.$movie->poster_image)))
    <img src="{{ asset('images/posters/'.$movie->poster_image) }}"
         alt="{{ $movie->title }}" style="width:100%;display:block;aspect-ratio:2/3;object-fit:cover;">
@else
    <div style="aspect-ratio:2/3;background:linear-gradient(135deg,#1a0000,#2d0808);display:flex;align-items:center;justify-content:center;font-size:60px;">🎬</div>
@endif
            </div>

            {{-- Info --}}
            <div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:1rem;">
                    <span class="badge badge-red">{{ $movie->genre }}</span>
                    <span class="badge badge-gray">{{ $movie->language }}</span>
                    <span class="badge badge-gray">{{ $movie->age_rating }}</span>
                    @if($movie->status === 'now_showing')
                        <span class="badge badge-green">Now Showing</span>
                    @elseif($movie->status === 'coming_soon')
                        <span class="badge badge-orange">Coming Soon</span>
                    @endif
                </div>

                <h1 style="font-size:clamp(28px,4vw,42px); font-weight:900; margin-bottom:.75rem; line-height:1.1;">{{ $movie->title }}</h1>

                <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:1.25rem; flex-wrap:wrap;">
                    <div style="display:flex; align-items:center; gap:5px; color:var(--yellow); font-size:15px; font-weight:700;">
                        ★ {{ number_format($movie->avg_rating,1) }}
                        <span style="color:var(--text-3); font-size:12px; font-weight:400;">({{ $movie->reviews->count() }} reviews)</span>
                    </div>
                    <span style="color:var(--text-3);">{{ $movie->duration_minutes }} min</span>
                    @if($movie->director)
                        <span style="color:var(--text-3);">Dir: {{ $movie->director }}</span>
                    @endif
                </div>

                <p style="color:rgba(255,255,255,.7); line-height:1.8; margin-bottom:1.5rem; max-width:560px; font-size:15px;">
                    {{ $movie->description }}
                </p>

                @if($movie->cast)
                <div style="margin-bottom:1.5rem;">
                    <span style="font-size:11px; color:var(--text-3); text-transform:uppercase; letter-spacing:.06em; font-weight:700;">Cast</span>
                    <p style="color:var(--text-2); font-size:14px; margin-top:4px;">{{ $movie->cast }}</p>
                </div>
                @endif

                {{-- BOOK NOW button — opens show picker modal --}}
                @if($movie->status === 'now_showing' && $shows->count())
                    <button onclick="document.getElementById('showPicker').style.display='flex'"
                        style="display:inline-flex; align-items:center; gap:9px; background:var(--red); color:#fff; padding:13px 28px; border-radius:8px; font-size:15px; font-weight:700; border:none; cursor:pointer; transition:all .25s; box-shadow:0 4px 20px rgba(211,47,35,.4); font-family:var(--font-body);"
                        onmouseover="this.style.background='#b52a1e'"
                        onmouseout="this.style.background='var(--red)'">
                        🎟️ Book Now
                    </button>
                @elseif($movie->status === 'coming_soon')
                    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(234,107,29,.12); border:1px solid rgba(234,107,29,.3); color:var(--orange); padding:12px 22px; border-radius:8px; font-size:14px; font-weight:600;">
                        🕐 Coming Soon — Bookings not open yet
                    </div>
                @else
                    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,.06); border:1px solid var(--border-2); color:var(--text-3); padding:12px 22px; border-radius:8px; font-size:14px;">
                        No shows available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== SHOW PICKER MODAL ===== --}}
@if($shows->count())
<div id="showPicker" style="display:none; position:fixed; inset:0; z-index:500; background:rgba(0,0,0,.8); backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:1rem;">
    <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-xl); width:100%; max-width:560px; max-height:90vh; overflow-y:auto;">

        {{-- Modal header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-1);">
            <div>
                <div style="font-size:16px; font-weight:800;">Select Show Time</div>
                <div style="font-size:12px; color:var(--text-3); margin-top:2px;">{{ $movie->title }}</div>
            </div>
            <button onclick="document.getElementById('showPicker').style.display='none'"
                style="background:var(--surface-3); border:1px solid var(--border-2); border-radius:6px; color:var(--text-2); width:32px; height:32px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">✕</button>
        </div>

        {{-- Show dates + times --}}
        <div style="padding:1.5rem; display:flex; flex-direction:column; gap:1.25rem;">
            @foreach($shows as $date => $dayShows)
            <div>
                <div style="font-size:12px; font-weight:700; color:var(--text-3); text-transform:uppercase; letter-spacing:.07em; margin-bottom:.75rem;">
                    {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                    @if($date === today()->format('Y-m-d'))
                        <span style="color:var(--green); margin-left:6px;">Today</span>
                    @endif
                </div>
                <div style="display:flex; flex-wrap:wrap; gap:10px;">
                    @foreach($dayShows as $show)
                    <a href="{{ route('booking.seats', $show->id) }}"
                       style="display:block; background:var(--surface-3); border:1px solid var(--border-2); border-radius:var(--radius-sm); padding:12px 18px; text-decoration:none; transition:all .2s; min-width:140px;"
                       onmouseover="this.style.borderColor='var(--red)'; this.style.background='rgba(211,47,35,.08)'"
                       onmouseout="this.style.borderColor='var(--border-2)'; this.style.background='var(--surface-3)'">
                        <div style="font-size:18px; font-weight:800; color:#fff;">
                            {{ \Carbon\Carbon::parse($show->show_time)->format('h:i A') }}
                        </div>
                        <div style="font-size:11px; color:var(--text-3); margin-top:3px;">{{ $show->theater->name }}</div>
                        <div style="display:flex; gap:10px; margin-top:7px; flex-wrap:wrap;">
                            <span style="font-size:10px; color:#EF9F27; font-weight:600;">G: Rs.{{ number_format($show->gold_price) }}</span>
                            <span style="font-size:10px; color:#378ADD; font-weight:600;">P: Rs.{{ number_format($show->platinum_price) }}</span>
                            <span style="font-size:10px; color:#7F77DD; font-weight:600;">B: Rs.{{ number_format($show->box_price) }}</span>
                        </div>
                        <div style="margin-top:6px;">
                            <span style="font-size:10px; color:var(--green); font-weight:600;">
                                ● {{ $show->available_seats }} seats left
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
{{-- Close modal on backdrop click --}}
<script>
document.getElementById('showPicker').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endif

{{-- TRAILER --}}
@if($movie->trailer_url)
<section style="padding:3rem 0; background:var(--surface-1); border-top:1px solid var(--border-1);">
    <div class="container">
        <h2 class="section-title" style="margin-bottom:1.5rem;">Trailer</h2>
        <div style="position:relative; padding-bottom:56.25%; border-radius:var(--radius-lg); overflow:hidden; border:1px solid var(--border-1);">
            @php
                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $movie->trailer_url, $matches);
                $ytId = $matches[1] ?? null;
            @endphp
            @if($ytId)
                <iframe style="position:absolute;top:0;left:0;width:100%;height:100%;"
                    src="https://www.youtube.com/embed/{{ $ytId }}" frameborder="0" allowfullscreen></iframe>
            @endif
        </div>
    </div>
</section>
@endif

{{-- REVIEWS --}}
<section style="padding:3rem 0; border-top:1px solid var(--border-1);">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 360px; gap:2.5rem; align-items:start;">
            <div>
                <h2 class="section-title" style="margin-bottom:1.5rem;">
                    Reviews
                    <span style="font-size:14px; font-weight:400; color:var(--text-3); margin-left:8px;">{{ $reviews->count() }}</span>
                </h2>
                @forelse($reviews as $review)
                <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-md); padding:1.25rem; margin-bottom:1rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800;">
                                {{ strtoupper(substr($review->user->name,0,1)) }}
                            </div>
                            <div>
                                <div style="font-size:14px; font-weight:600;">{{ $review->user->name }}</div>
                                <div style="font-size:11px; color:var(--text-3);">{{ $review->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div style="color:var(--yellow);">
                            @for($i=1;$i<=5;$i++) {{ $i<=$review->rating?'★':'☆' }} @endfor
                        </div>
                    </div>
                    @if($review->review_text)
                        <p style="font-size:14px; color:var(--text-2); line-height:1.7;">{{ $review->review_text }}</p>
                    @endif
                </div>
                @empty
                    <p style="color:var(--text-3); font-size:14px;">No reviews yet. Be the first!</p>
                @endforelse
            </div>

            @auth
            <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-md); padding:1.5rem; position:sticky; top:80px;">
                <h3 style="font-size:16px; font-weight:700; margin-bottom:1.25rem;">Write a Review</h3>
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                    <div class="form-group">
                        <label class="form-label">Your Rating</label>
                        <div style="display:flex; gap:6px;" id="starRow">
                            @for($i=1;$i<=5;$i++)
                                <button type="button" class="star-btn" data-val="{{ $i }}"
                                    style="background:none; border:none; font-size:26px; color:var(--text-4); cursor:pointer; padding:0; transition:color .15s;"
                                    onclick="setRating({{ $i }})">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Review (Optional)</label>
                        <textarea name="review_text" class="form-control" rows="4" placeholder="Share your thoughts..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit Review</button>
                </form>
            </div>
            @else
            <div style="background:var(--surface-2); border:1px solid var(--border-1); border-radius:var(--radius-md); padding:1.5rem; text-align:center;">
                <p style="color:var(--text-2); margin-bottom:1rem; font-size:14px;">Login to write a review</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-block">Sign In</a>
            </div>
            @endauth
        </div>
    </div>
</section>

{{-- RELATED --}}
@if($related->count())
<section style="padding:3rem 0; background:var(--surface-1); border-top:1px solid var(--border-1);">
    <div class="container">
        <h2 class="section-title" style="margin-bottom:1.5rem;">More {{ $movie->genre }} Movies</h2>
        <div class="grid-movies">
            @foreach($related as $m)
                @include('partials.movie-card', ['movie' => $m])
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
function setRating(val) {
    document.getElementById('ratingInput').value = val;
    document.querySelectorAll('.star-btn').forEach(function(s,i) {
        s.style.color = i < val ? 'var(--yellow)' : 'var(--text-4)';
    });
}
</script>
@endpush
@endsection