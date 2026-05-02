@extends('layouts.admin')
@section('title','Edit Movie')
@section('page-title','Edit Movie')

@section('content')
<div style="max-width:720px;">
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.5rem;">
        <form method="POST" action="{{ route('admin.movies.update',$movie->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            @if($errors->any())
                <div class="alert alert-error mb-3">{{ $errors->first() }}</div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Movie Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title',$movie->title) }}" required>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description',$movie->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Genre *</label>
                    <select name="genre" class="form-control" required>
                        @foreach(['Action','Thriller','Drama','Comedy','Romance','Horror','Animation','Sci-Fi'] as $g)
                            <option value="{{ $g }}" {{ old('genre',$movie->genre)===$g?'selected':'' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Language *</label>
                    <select name="language" class="form-control" required>
                        @foreach(['English','Urdu','Hindi','Punjabi'] as $l)
                            <option value="{{ $l }}" {{ old('language',$movie->language)===$l?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Duration (minutes) *</label>
                    <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes',$movie->duration_minutes) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Release Date *</label>
                    <input type="date" name="release_date" class="form-control" value="{{ old('release_date',$movie->release_date->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Age Rating *</label>
                    <select name="age_rating" class="form-control" required>
                        @foreach(['G','PG','PG-13','R','NC-17'] as $r)
                            <option value="{{ $r }}" {{ old('age_rating',$movie->age_rating)===$r?'selected':'' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="coming_soon" {{ old('status',$movie->status)==='coming_soon'?'selected':'' }}>Coming Soon</option>
                        <option value="now_showing" {{ old('status',$movie->status)==='now_showing'?'selected':'' }}>Now Showing</option>
                        <option value="ended"       {{ old('status',$movie->status)==='ended'?'selected':'' }}>Ended</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Director</label>
                    <input type="text" name="director" class="form-control" value="{{ old('director',$movie->director) }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Cast</label>
                    <input type="text" name="cast" class="form-control" value="{{ old('cast',$movie->cast) }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Trailer URL</label>
                    <input type="url" name="trailer_url" class="form-control" value="{{ old('trailer_url',$movie->trailer_url) }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Poster Image (leave empty to keep current)</label>
                    @if($movie->poster_image)
                        <img src="{{ asset('images/posters/'.$movie->poster_image) }}"
                             style="width:60px;height:82px;object-fit:cover;border-radius:5px;margin-bottom:8px;display:block;border:1px solid var(--border-2);">
                    @endif
                    <input type="file" name="poster_image" class="form-control" accept="image/*" onchange="previewPoster(this)">
                    <img id="posterPreview" style="margin-top:8px;width:80px;height:110px;object-fit:cover;border-radius:6px;display:none;border:1px solid var(--border-2);">
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:.5rem;">
                <button type="submit" class="btn btn-primary">Update Movie</button>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
function previewPoster(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('posterPreview');
            img.src = e.target.result; img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection