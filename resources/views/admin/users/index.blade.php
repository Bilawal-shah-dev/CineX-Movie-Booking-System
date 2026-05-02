@extends('layouts.admin')
@section('title','Users')
@section('page-title','Registered Users')

@section('content')
<div class="table-wrap">
    <table class="cx-table">
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Bookings</th><th>Role</th><th>Joined</th></tr></thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;">
                            {{ strtoupper(substr($u->name,0,1)) }}
                        </div>
                        <span style="font-weight:600;font-size:14px;">{{ $u->name }}</span>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--text-2);">{{ $u->email }}</td>
                <td style="font-size:13px;color:var(--text-2);">{{ $u->phone ?? '—' }}</td>
                <td><span class="badge badge-gray">{{ $u->bookings_count }}</span></td>
                <td>
                    <span class="badge {{ $u->is_admin?'badge-red':'badge-gray' }}">
                        {{ $u->is_admin?'Admin':'User' }}
                    </span>
                </td>
                <td style="font-size:12px;color:var(--text-3);">{{ $u->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="margin-top:1rem;">{{ $users->links() }}</div>
@endsection