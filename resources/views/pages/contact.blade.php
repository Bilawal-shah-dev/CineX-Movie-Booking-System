@extends('layouts.app')
@section('title', 'Contact Us — CineX')
@section('content')

<div style="padding:3.5rem 0 3rem;background:var(--surface-1);border-bottom:1px solid var(--border-1);text-align:center;">
    <div class="container">
        <h1 style="font-size:clamp(28px,4vw,42px);font-weight:900;margin-bottom:.75rem;">Get in <span class="text-red">Touch</span></h1>
        <p style="color:var(--text-3);font-size:15px;">Have questions or feedback? We'd love to hear from you.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1.4fr;gap:3rem;align-items:start;">

            {{-- Contact Info --}}
            <div>
                <h2 style="font-size:22px;font-weight:800;margin-bottom:1.5rem;">Contact Information</h2>
                @foreach([
                    ['📍','Address',   'Aptech Computer Education, Johar Campus, Karachi, Pakistan'],
                    ['📧','Email',     'support@cinex.pk'],
                    ['📞','Phone',     '+92 321 000 0000'],
                    ['🕐','Hours',     'Mon–Sat, 9:00 AM – 9:00 PM'],
                    ['💬','Response',  'Within 24 hours'],
                ] as $c)
                <div style="display:flex;gap:14px;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid var(--border-1);">
                    <div style="font-size:22px;flex-shrink:0;margin-top:2px;">{{ $c[0] }}</div>
                    <div>
                        <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;font-weight:700;margin-bottom:3px;">{{ $c[1] }}</div>
                        <div style="font-size:14px;color:var(--text-2);">{{ $c[2] }}</div>
                    </div>
                </div>
                @endforeach

                <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.25rem;margin-top:.5rem;">
                    <div style="font-size:13px;font-weight:700;color:var(--white);margin-bottom:6px;">eProject Submission</div>
                    <div style="font-size:12px;color:var(--text-3);line-height:1.6;">
                        Submit queries to: <a href="mailto:eprojects@aglsm.com" style="color:var(--orange);">eprojects@aglsm.com</a><br>
                        Deadline: 25 May 2026
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:2rem;">
                <h3 style="font-size:18px;font-weight:700;margin-bottom:1.5rem;">Send a Message</h3>

                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom:1rem;">✓ {{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error" style="margin-bottom:1rem;">⚠ {{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('pages.contact.submit') }}">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="padding:13px;">Send Message</button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection