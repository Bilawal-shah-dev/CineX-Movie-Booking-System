@extends('layouts.app')
@section('title','404 — Page Not Found')
@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;">
    <div>
        <div style="font-size:100px;font-weight:900;color:var(--red);line-height:1;opacity:.15;font-family:var(--font-heading);">404</div>
        <div style="margin-top:-30px;">
            <h1 style="font-size:28px;font-weight:800;margin-bottom:.75rem;">Page Not Found</h1>
            <p style="color:var(--text-3);margin-bottom:2rem;">The page you're looking for doesn't exist or has been moved.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
        </div>
    </div>
</div>
@endsection