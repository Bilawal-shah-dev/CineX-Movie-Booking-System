<a href="{{ route('movies.show', $movie->slug) }}" class="movie-card" style="display:block;text-decoration:none;">
    <div class="movie-poster">
        @if($movie->poster_image && file_exists(public_path('images/posters/'.$movie->poster_image)))
            <img src="{{ asset('images/posters/'.$movie->poster_image) }}"
                 alt="{{ $movie->title }}"
                 style="width:100%;height:100%;object-fit:cover;">
        @else
            <div class="movie-poster-placeholder">🎬</div>
        @endif

        <div class="movie-badge">{{ $movie->genre }}</div>

        @if($movie->status === 'now_showing')
            <div class="movie-badge-new">NOW</div>
        @elseif($movie->status === 'coming_soon')
            <div class="movie-badge-new" style="background:var(--orange);">SOON</div>
        @endif

        <div class="movie-overlay">
            <span class="btn btn-primary btn-sm">Book Now</span>
        </div>
    </div>
    <div class="movie-info">
        <div class="movie-title">{{ $movie->title }}</div>
        <div class="movie-meta">
            <div class="movie-rating">★ {{ number_format($movie->avg_rating, 1) }}</div>
            <div class="movie-duration">{{ $movie->duration_minutes }}m</div>
        </div>
    </div>
</a>