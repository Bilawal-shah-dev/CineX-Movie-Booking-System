@extends('layouts.app')
@section('title', 'Movies — CineX')

@section('content')

<div style="background:var(--surface-1); border-bottom:1px solid var(--border-1); padding:2rem 0;">
    <div class="container">
        <h1 style="font-size:28px; font-weight:800; margin-bottom:1.5rem;">All Movies</h1>

        {{-- SEARCH & FILTER BAR --}}
        <form method="GET" action="{{ route('movies.index') }}" id="filterForm">
            <div style="display:grid; grid-template-columns:1fr auto auto auto auto; gap:10px; align-items:end; flex-wrap:wrap;">

                <div>
                    <input type="text" name="search" class="form-control"
                           placeholder="&#128269; Search movies..."
                           value="{{ request('search') }}">
                </div>

                <div>
                    <select name="genre" class="form-control" onchange="this.form.submit()">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="now_showing" {{ request('status') == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                        <option value="coming_soon" {{ request('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                    </select>
                </div>

                <div>
                    <select name="rating" class="form-control" onchange="this.form.submit()">
                        <option value="">Any Rating</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                    </select>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                    @if(request()->anyFilled(['search','genre','status','rating']))
                        <a href="{{ route('movies.index') }}" class="btn btn-outline">Clear</a>
                    @endif
                </div>

            </div>
        </form>
    </div>
</div>

<section class="section">
    <div class="container">

        {{-- Results count --}}
        <div style="margin-bottom:1.5rem; color:var(--text-3); font-size:13px;">
            {{ $movies->total() }} movies found
            @if(request('search'))
                for "<span style="color:var(--white);">{{ request('search') }}</span>"
            @endif
        </div>

        @if($movies->count())
            <div class="grid-movies">
                @foreach($movies as $movie)
                    @include('partials.movie-card', ['movie' => $movie])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($movies->hasPages())
                <div style="margin-top:2.5rem; display:flex; justify-content:center; gap:8px;">
                    @if($movies->onFirstPage())
                        <span class="btn btn-outline btn-sm" style="opacity:.3; cursor:not-allowed;">&#8592; Prev</span>
                    @else
                        <a href="{{ $movies->previousPageUrl() }}" class="btn btn-outline btn-sm">&#8592; Prev</a>
                    @endif

                    <span style="padding:7px 14px; font-size:13px; color:var(--text-2);">
                        Page {{ $movies->currentPage() }} of {{ $movies->lastPage() }}
                    </span>

                    @if($movies->hasMorePages())
                        <a href="{{ $movies->nextPageUrl() }}" class="btn btn-outline btn-sm">Next &#8594;</a>
                    @else
                        <span class="btn btn-outline btn-sm" style="opacity:.3; cursor:not-allowed;">Next &#8594;</span>
                    @endif
                </div>
            @endif

        @else
            <div style="text-align:center; padding:4rem 0; color:var(--text-3);">
                <div style="font-size:64px; margin-bottom:1rem;">&#127909;</div>
                <h3 style="margin-bottom:.5rem; color:var(--text-2);">No movies found</h3>
                <p style="margin-bottom:1.5rem;">Try different filters ya search term.</p>
                <a href="{{ route('movies.index') }}" class="btn btn-primary">View All Movies</a>
            </div>
        @endif

    </div>
</section>

@endsection