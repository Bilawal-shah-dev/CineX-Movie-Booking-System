@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

{{-- Stats Row --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
    @foreach([
        ['🎟️', 'Total Bookings',   number_format($stats['total_bookings']),   'var(--red)',    '+'.$stats['today_bookings'].' today'],
        ['💰', 'Total Revenue',    'Rs.'.number_format($stats['total_revenue']),'var(--green)', 'All time earnings'],
        ['🎬', 'Active Movies',    $stats['total_movies'],                      'var(--orange)','Now showing: '.$stats['now_showing']],
        ['👥', 'Registered Users', $stats['total_users'],                       '#378ADD',      'Excluding admins'],
    ] as $s)
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.25rem;position:relative;overflow:hidden;transition:border-color .2s;"
         onmouseover="this.style.borderColor='{{ $s[3] }}'" onmouseout="this.style.borderColor='var(--border-1)'">
        <div style="position:absolute;top:-10px;right:-10px;font-size:64px;opacity:.06;">{{ $s[0] }}</div>
        <div style="font-size:22px;margin-bottom:6px;">{{ $s[0] }}</div>
        <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:4px;">{{ $s[1] }}</div>
        <div style="font-size:28px;font-weight:900;color:{{ $s[3] }};line-height:1;margin-bottom:4px;">{{ $s[2] }}</div>
        <div style="font-size:11px;color:var(--text-3);">{{ $s[4] }}</div>
    </div>
    @endforeach
</div>

{{-- Charts + Top Movies --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">

    {{-- Weekly bookings bar chart --}}
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.5rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div style="font-size:15px;font-weight:700;">Weekly Bookings</div>
            <span class="badge badge-gray">Last 7 days</span>
        </div>
        <div style="display:flex;align-items:flex-end;gap:10px;height:140px;">
            @php $maxCount = max(array_column($weeklyBookings,'count')) ?: 1; @endphp
            @foreach($weeklyBookings as $day)
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;">
                <div style="font-size:11px;color:var(--text-3);font-weight:600;">{{ $day['count'] }}</div>
                <div style="width:100%;min-height:4px;background:linear-gradient(to top,var(--red),#ea6b1d);border-radius:4px 4px 0 0;opacity:.85;transition:all .3s;height:{{ max(4,($day['count']/$maxCount)*110) }}px;"
                     onmouseover="this.style.opacity=1;this.style.boxShadow='0 0 12px rgba(211,47,35,.4)'"
                     onmouseout="this.style.opacity=.85;this.style.boxShadow='none'"
                     title="{{ $day['count'] }} bookings · Rs.{{ number_format($day['rev']) }}"></div>
                <div style="font-size:10px;color:var(--text-3);font-weight:500;">{{ $day['day'] }}</div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-1);display:flex;gap:1.5rem;flex-wrap:wrap;">
            <div>
                <div style="font-size:10px;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;">Week Total</div>
                <div style="font-size:16px;font-weight:700;color:var(--white);">{{ array_sum(array_column($weeklyBookings,'count')) }} bookings</div>
            </div>
            <div>
                <div style="font-size:10px;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;">Week Revenue</div>
                <div style="font-size:16px;font-weight:700;color:var(--green);">Rs.{{ number_format(array_sum(array_column($weeklyBookings,'rev'))) }}</div>
            </div>
        </div>
    </div>

    {{-- Top 5 Movies --}}
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.5rem;">
        <div style="font-size:15px;font-weight:700;margin-bottom:1.25rem;">Top Movies</div>
        @php $maxBookings = $topMovies->max('bookings_count') ?: 1; @endphp
        @foreach($topMovies as $i => $m)
        <div style="margin-bottom:.9rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:20px;height:20px;background:{{ $i===0?'var(--red)':($i===1?'var(--orange)':'var(--surface-4)') }};border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;flex-shrink:0;">{{ $i+1 }}</div>
                    <div style="font-size:12px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $m->title }}</div>
                </div>
                <div style="font-size:11px;color:var(--text-3);">{{ $m->bookings_count }}</div>
            </div>
            <div style="height:4px;background:var(--surface-3);border-radius:2px;overflow:hidden;">
                <div style="height:100%;width:{{ ($m->bookings_count/$maxBookings)*100 }}%;background:linear-gradient(90deg,var(--red),var(--orange));border-radius:2px;transition:width .5s;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Quick Actions --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:1.5rem;">
    @foreach([
        [route('admin.movies.create'), '🎬', 'Add Movie',    'var(--red)'],
        [route('admin.theaters.index'),'🏢', 'Add Theater',  'var(--orange)'],
        [route('admin.shows.index'),   '🕐', 'Add Show',     '#378ADD'],
        [route('admin.bookings.index'),'🎟️', 'All Bookings', 'var(--green)'],
        [route('admin.users.index'),   '👥', 'Users List',   '#7F77DD'],
    ] as $qa)
    <a href="{{ $qa[0] }}"
       style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1rem;text-align:center;text-decoration:none;transition:all .2s;"
       onmouseover="this.style.borderColor='{{ $qa[3] }}';this.style.transform='translateY(-2px)'"
       onmouseout="this.style.borderColor='var(--border-1)';this.style.transform='none'">
        <div style="font-size:24px;margin-bottom:6px;">{{ $qa[1] }}</div>
        <div style="font-size:12px;font-weight:600;color:{{ $qa[3] }};">{{ $qa[2] }}</div>
    </a>
    @endforeach
</div>

{{-- Recent Bookings --}}
<div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
        <div style="font-size:15px;font-weight:700;">Recent Bookings</div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline btn-sm">View All</a>
    </div>
    <div class="table-wrap">
        <table class="cx-table">
            <thead>
                <tr><th>Booking ID</th><th>User</th><th>Movie</th><th>Seats</th><th>Amount</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $b)
                <tr>
                    <td>
                        <span style="font-family:var(--font-mono);font-size:11px;color:var(--orange);">{{ $b->booking_id }}</span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;">
                                {{ strtoupper(substr($b->user->name,0,1)) }}
                            </div>
                            <span style="font-size:13px;">{{ $b->user->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;font-weight:600;">{{ $b->show->movie->title }}</td>
                    <td>
                        <span class="badge badge-gray">{{ $b->num_seats }} seats</span>
                    </td>
                    <td style="color:var(--orange);font-weight:700;font-size:13px;">Rs.{{ number_format($b->total_amount) }}</td>
                    <td>
                        <span class="badge {{ $b->status==='confirmed'?'badge-green':'badge-red' }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:var(--text-3);">{{ $b->created_at->format('d M, h:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--text-3);padding:2rem;">No bookings yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection