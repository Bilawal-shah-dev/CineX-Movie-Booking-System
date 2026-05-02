@extends('layouts.admin')
@section('title','Bookings')
@section('page-title','All Bookings')

@section('content')
<form method="GET" style="display:flex;gap:10px;margin-bottom:1.25rem;flex-wrap:wrap;">
    <input type="text" name="search" class="form-control" placeholder="Search booking ID or user..." value="{{ request('search') }}" style="max-width:280px;">
    <select name="status" class="form-control" style="max-width:160px;" onchange="this.form.submit()">
        <option value="">All Status</option>
        <option value="confirmed" {{ request('status')==='confirmed'?'selected':'' }}>Confirmed</option>
        <option value="cancelled" {{ request('status')==='cancelled'?'selected':'' }}>Cancelled</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    @if(request()->anyFilled(['search','status']))
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline btn-sm">Clear</a>
    @endif
</form>

<div class="table-wrap">
    <table class="cx-table">
        <thead>
            <tr><th>Booking ID</th><th>User</th><th>Movie</th><th>Show</th><th>Seats</th><th>Amount</th><th>Payment</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td><span style="font-family:var(--font-mono);font-size:11px;color:var(--orange);">{{ $b->booking_id }}</span></td>
                <td>
                    <div style="font-size:13px;font-weight:600;">{{ $b->user->name }}</div>
                    <div style="font-size:11px;color:var(--text-3);">{{ $b->user->email }}</div>
                </td>
                <td style="font-size:13px;font-weight:600;">{{ $b->show->movie->title }}</td>
                <td style="font-size:12px;color:var(--text-2);">
                    {{ $b->show->show_date->format('d M Y') }}<br>
                    {{ \Carbon\Carbon::parse($b->show->show_time)->format('h:i A') }}
                </td>
                <td style="font-size:12px;font-family:var(--font-mono);">{{ implode(', ',$b->seat_numbers) }}</td>
                <td style="color:var(--orange);font-weight:700;">Rs.{{ number_format($b->total_amount) }}</td>
                <td><span class="badge {{ $b->payment_status==='paid'?'badge-green':'badge-orange' }}">{{ ucfirst($b->payment_status) }}</span></td>
                <td><span class="badge {{ $b->status==='confirmed'?'badge-green':'badge-red' }}">{{ ucfirst($b->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="margin-top:1rem;">{{ $bookings->links() }}</div>
@endsection