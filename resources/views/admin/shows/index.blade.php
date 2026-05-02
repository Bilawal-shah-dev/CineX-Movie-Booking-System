@extends('layouts.admin')
@section('title','Shows')
@section('page-title','Manage Shows')

@section('content')
<div style="display:grid;grid-template-columns:1fr 380px;gap:1.5rem;align-items:start;">

    {{-- Shows table --}}
    <div>
        <div class="table-wrap">
            <table class="cx-table">
                <thead><tr><th>Movie</th><th>Theater</th><th>Date</th><th>Time</th><th>Gold</th><th>Platinum</th><th>Box</th><th>Seats</th><th>Action</th></tr></thead>
                <tbody>
                    @foreach($shows as $s)
                    <tr>
                        <td style="font-weight:600;font-size:13px;">{{ $s->movie->title }}</td>
                        <td style="font-size:12px;color:var(--text-2);">{{ $s->theater->name }}</td>
                        <td style="font-size:12px;">{{ $s->show_date->format('d M Y') }}</td>
                        <td style="font-size:12px;">{{ \Carbon\Carbon::parse($s->show_time)->format('h:i A') }}</td>
                        <td style="color:#EF9F27;font-size:12px;">{{ number_format($s->gold_price) }}</td>
                        <td style="color:#378ADD;font-size:12px;">{{ number_format($s->platinum_price) }}</td>
                        <td style="color:#7F77DD;font-size:12px;">{{ number_format($s->box_price) }}</td>
                        <td>
                            <span class="badge {{ $s->available_seats>20?'badge-green':($s->available_seats>0?'badge-orange':'badge-red') }}">
                                {{ $s->available_seats }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.shows.destroy',$s->id) }}" onsubmit="return confirm('Delete show?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(211,47,35,.12);border:1px solid rgba(211,47,35,.3);color:var(--red);">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $shows->links() }}</div>
    </div>

    {{-- Add Show form --}}
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.25rem;position:sticky;top:80px;">
        <div style="font-size:14px;font-weight:700;margin-bottom:1rem;">Add New Show</div>
        <form method="POST" action="{{ route('admin.shows.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Movie *</label>
                <select name="movie_id" class="form-control" required>
                    <option value="">Select movie</option>
                    @foreach($movies as $m)
                        <option value="{{ $m->id }}">{{ $m->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Theater *</label>
                <select name="theater_id" class="form-control" required>
                    <option value="">Select theater</option>
                    @foreach($theaters as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date *</label>
                <input type="date" name="show_date" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Time *</label>
                <input type="time" name="show_time" class="form-control" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                <div class="form-group">
                    <label class="form-label" style="color:#EF9F27;">Gold Rs.</label>
                    <input type="number" name="gold_price" class="form-control" value="800" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="color:#378ADD;">Platinum</label>
                    <input type="number" name="platinum_price" class="form-control" value="1200" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="color:#7F77DD;">Box Rs.</label>
                    <input type="number" name="box_price" class="form-control" value="2000" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Show</button>
        </form>
    </div>
</div>
@endsection