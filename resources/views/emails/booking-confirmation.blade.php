<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Booking Confirmed — CineX</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{background:#0a0a0a;font-family:'Helvetica Neue',Arial,sans-serif;color:#fff;}
  .wrap{max-width:560px;margin:0 auto;padding:32px 16px;}
  .card{background:#111;border:1px solid #222;border-radius:16px;overflow:hidden;}
  .header{background:linear-gradient(135deg,#d32f23,#ea6b1d);padding:28px 28px 24px;}
  .header-logo{font-size:24px;font-weight:900;letter-spacing:-.02em;color:#fff;margin-bottom:8px;}
  .header-logo span{color:rgba(255,255,255,.7);}
  .header h1{font-size:20px;font-weight:700;color:#fff;margin-bottom:4px;}
  .header p{font-size:13px;color:rgba(255,255,255,.75);}
  .ticket-id{background:rgba(0,0,0,.25);border-radius:8px;padding:12px 16px;margin:16px 0 0;text-align:center;}
  .ticket-id span{font-family:'Courier New',monospace;font-size:18px;font-weight:700;color:#fff;letter-spacing:.08em;}
  .body{padding:24px 28px;}
  .row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #1e1e1e;font-size:14px;}
  .row:last-child{border-bottom:none;}
  .row-label{color:#666;font-weight:500;}
  .row-value{color:#fff;font-weight:600;text-align:right;}
  .total-row{background:#1a0800;border-radius:8px;padding:14px 16px;margin:16px 0;display:flex;justify-content:space-between;align-items:center;}
  .total-label{font-size:14px;color:#888;}
  .total-value{font-size:22px;font-weight:900;color:#ea6b1d;}
  .seats-box{background:#0d0d0d;border:1px solid #1e1e1e;border-radius:8px;padding:14px 16px;margin:16px 0;}
  .seats-label{font-size:11px;color:#555;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:6px;}
  .seats-list{font-family:'Courier New',monospace;font-size:14px;color:#fff;font-weight:600;}
  .footer{padding:20px 28px;border-top:1px solid #1a1a1a;text-align:center;}
  .footer p{font-size:12px;color:#444;line-height:1.6;}
  .badge{display:inline-block;padding:4px 10px;border-radius:5px;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;}
  .badge-green{background:rgba(40,167,69,.15);color:#5dd87a;border:1px solid rgba(40,167,69,.3);}
  .divider{height:1px;background:linear-gradient(90deg,transparent,#2a2a2a,transparent);margin:0;}
  .tear{display:flex;align-items:center;margin:0 -1px;}
  .tear-dot{width:16px;height:16px;background:#0a0a0a;border-radius:50%;flex-shrink:0;}
  .tear-line{flex:1;border-top:2px dashed #1e1e1e;}
</style>
</head>
<body>
<div class="wrap">

  {{-- Header --}}
  <div class="card">
    <div class="header">
      <div class="header-logo">CINE<span>X</span></div>
      <h1>Your Booking is Confirmed! 🎬</h1>
      <p>Thank you {{ $booking->user->name }}. Enjoy your movie!</p>
      <div class="ticket-id">
        <div style="font-size:10px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.1em;margin-bottom:4px;">Booking ID</div>
        <span>{{ $booking->booking_id }}</span>
      </div>
    </div>

    {{-- Tear --}}
    <div class="tear">
      <div class="tear-dot" style="margin-left:-8px;"></div>
      <div class="tear-line"></div>
      <div class="tear-dot" style="margin-right:-8px;"></div>
    </div>

    {{-- Body --}}
    <div class="body">

      <div style="margin-bottom:16px;">
        <div style="font-size:11px;color:#555;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:6px;">Movie</div>
        <div style="font-size:20px;font-weight:800;color:#fff;">{{ $booking->show->movie->title }}</div>
        <div style="font-size:13px;color:#888;margin-top:3px;">{{ $booking->show->movie->genre }} &bull; {{ $booking->show->movie->duration_minutes }} min</div>
      </div>

      <div class="row">
        <span class="row-label">Theater</span>
        <span class="row-value">{{ $booking->show->theater->name }}</span>
      </div>
      <div class="row">
        <span class="row-label">Date</span>
        <span class="row-value">{{ $booking->show->show_date->format('l, d M Y') }}</span>
      </div>
      <div class="row">
        <span class="row-label">Time</span>
        <span class="row-value">{{ \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A') }}</span>
      </div>
      <div class="row">
        <span class="row-label">Seat Class</span>
        <span class="row-value">{{ ucfirst($booking->seat_class) }}</span>
      </div>
      <div class="row">
        <span class="row-label">Payment</span>
        <span class="row-value"><span class="badge badge-green">{{ ucfirst($booking->payment_method) }} ✓</span></span>
      </div>

      <div class="seats-box">
        <div class="seats-label">Seat Numbers</div>
        <div class="seats-list">{{ implode(' · ', $booking->seat_numbers) }}</div>
      </div>

      <div class="total-row">
        <span class="total-label">Total Paid</span>
        <span class="total-value">Rs. {{ number_format($booking->total_amount) }}</span>
      </div>

      <div style="background:rgba(40,167,69,.06);border:1px solid rgba(40,167,69,.2);border-radius:8px;padding:12px 14px;font-size:12px;color:#5dd87a;line-height:1.6;">
        ℹ️ You can cancel your booking up to 1 hour before show time from the <strong>My Bookings</strong> section.
      </div>
    </div>

    <div class="footer">
      <p>This is an automated email from CineX. Please do not reply.<br>
      &copy; {{ date('Y') }} CineX — Karachi's Premier Cinema Booking Platform</p>
    </div>
  </div>

</div>
</body>
</html>