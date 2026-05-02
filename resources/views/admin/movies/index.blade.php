@extends('layouts.admin')
@section('title','Movies')
@section('page-title','Manage Movies')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <div style="font-size:13px;color:var(--text-3);">{{ $movies->total() }} total movies</div>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary btn-sm">+ Add Movie</a>
</div>

<div class="table-wrap">
    <table class="cx-table">
        <thead>
            <tr><th>Poster</th><th>Title</th><th>Genre</th><th>Status</th><th>Rating</th><th>Release</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($movies as $m)
            <tr>
                <td>
                    @if($m->poster_image)
                        <img src="{{ asset('images/posters/'.$m->poster_image) }}" style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                    @else
                        <div style="width:40px;height:55px;background:var(--surface-3);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:18px;">🎬</div>
                    @endif
                </td>
                <td style="font-weight:600;">{{ $m->title }}</td>
                <td><span class="badge badge-gray">{{ $m->genre }}</span></td>
                <td>
                    <span class="badge {{ $m->status==='now_showing'?'badge-green':($m->status==='coming_soon'?'badge-orange':'badge-gray') }}">
                        {{ ucfirst(str_replace('_',' ',$m->status)) }}
                    </span>
                </td>
                <td style="color:var(--yellow);">★ {{ number_format($m->avg_rating,1) }}</td>
                <td style="font-size:12px;color:var(--text-3);">{{ $m->release_date->format('d M Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.movies.edit',$m->id) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.movies.destroy',$m->id) }}" onsubmit="return confirm('Delete this movie?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:rgba(211,47,35,.12);border:1px solid rgba(211,47,35,.3);color:var(--red);">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top:1rem;">{{ $movies->links() }}</div>
@endsection