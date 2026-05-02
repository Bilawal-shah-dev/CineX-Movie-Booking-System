@extends('layouts.admin')
@section('title','Add Movie')
@section('page-title','Add New Movie')

@section('content')
<div style="max-width:720px;">
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.5rem;">
        <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
                <div class="alert alert-error mb-3">{{ $errors->first() }}</div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Movie Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Genre *</label>
                    <select name="genre" class="form-control" required>
                        <option value="">Select genre</option>
                        @foreach(['Action','Thriller','Drama','Comedy','Romance','Horror','Animation','Sci-Fi'] as $g)
                            <option value="{{ $g }}" {{ old('genre')===$g?'selected':'' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Language *</label>
                    <select name="language" class="form-control" required>
                        @foreach(['English','Urdu','Hindi','Punjabi'] as $l)
                            <option value="{{ $l }}" {{ old('language')===$l?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Duration (minutes) *</label>
                    <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Release Date *</label>
                    <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Age Rating *</label>
                    <select name="age_rating" class="form-control" required>
                        @foreach(['G','PG','PG-13','R','NC-17'] as $r)
                            <option value="{{ $r }}" {{ old('age_rating')===$r?'selected':'' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="coming_soon" {{ old('status')==='coming_soon'?'selected':'' }}>Coming Soon</option>
                        <option value="now_showing" {{ old('status')==='now_showing'?'selected':'' }}>Now Showing</option>
                        <option value="ended"       {{ old('status')==='ended'?'selected':'' }}>Ended</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Director</label>
                    <input type="text" name="director" class="form-control" value="{{ old('director') }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Cast</label>
                    <input type="text" name="cast" class="form-control" value="{{ old('cast') }}" placeholder="Actor 1, Actor 2, ...">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Trailer URL (YouTube)</label>
                    <input type="url" name="trailer_url" class="form-control" value="{{ old('trailer_url') }}" placeholder="https://youtube.com/watch?v=...">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Poster Image</label>
                    <input type="file" name="poster_image" class="form-control" accept="image/*" onchange="previewPoster(this)">
                    <img id="posterPreview" style="margin-top:8px;width:80px;height:110px;object-fit:cover;border-radius:6px;display:none;border:1px solid var(--border-2);">
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:.5rem;">
                <button type="submit" class="btn btn-primary">Add Movie</button>
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
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection