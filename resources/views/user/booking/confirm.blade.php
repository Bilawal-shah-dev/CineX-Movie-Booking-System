@extends('layouts.app')
@section('title', 'Booking — ' . $booking->booking_id)

@php
    $isCancelled = $booking->status === 'cancelled';
    $isPartial   = $booking->isPartiallyCancelled();
    $isOk        = !$isCancelled && !$isPartial;
    $showDT      = \Carbon\Carbon::parse(
                       $booking->show->show_date->format('Y-m-d')
                       .' '.$booking->show->show_time
                   );
    $canCancel   = now()->diffInMinutes($showDT, false) > 60
                   && !$isCancelled
                   && count($booking->active_seats) > 0;

    // Recalculate amount based on active seats only
    $priceMap    = [
        'gold'     => (float)$booking->show->gold_price,
        'platinum' => (float)$booking->show->platinum_price,
        'box'      => (float)$booking->show->box_price,
    ];
    $unitPrice      = $priceMap[$booking->seat_class] ?? 0;
    $activeCount    = count($booking->active_seats);
    $cancelledCount = count($booking->cancelled_seats ?? []);
    $kidsCount      = min((int)$booking->kids_count, $activeCount);
    $adultCount     = max(0, $activeCount - $kidsCount);
    $currentAmount  = ($adultCount * $unitPrice) + ($kidsCount * $unitPrice * 0.5);
    $refundedAmount = $booking->total_amount - $currentAmount;
@endphp

@section('content')

{{-- PRINT CSS: Only ticket visible when printing --}}
<style>
@media print {
    *                { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    body             { margin:0; padding:0; background:#050000 !important; }
    .no-print        { display:none !important; }
    .navbar, footer, .footer, nav, .alert-wrap, .action-btns, #cancelSection, .page-header { display:none !important; }
    main             { padding:0 !important; }
    .print-only-wrap { display:flex !important; align-items:center; justify-content:center; min-height:100vh; background:#050000; padding:0; margin:0; }
    #ticketCard      { width:800px !important; max-width:800px !important; margin:0 auto !important; page-break-inside:avoid !important; }
    @page            { size: A4 landscape; margin:10mm; }
}
@media screen {
    .print-only-wrap { display:contents; }
}
</style>

<div style="position:relative;min-height:100vh;background:var(--black);overflow:hidden;padding:3rem 0 4rem;">

    <div style="position:absolute;inset:0;z-index:0;">
        <img src="{{ asset('images\hero\cinema_bg.jpg') }}" alt=""
     style="width:100%;height:100%;object-fit:cover;opacity:.15;"
     onerror="this.style.display='none'">
        <div style="position:absolute;inset:0;background:rgba(0,0,0,.78);"></div>
    </div>

    <div class="container" style="position:relative;z-index:1;">

        {{-- Alerts --}}
        <div class="alert-wrap">
            @if(session('cancel_success'))
                <div class="alert alert-success" style="max-width:700px;margin:0 auto 1.5rem;">
                    ✓ {{ session('cancel_success') }}
                    @if($refundedAmount > 0)
                        — <strong>Rs.{{ number_format($refundedAmount) }}</strong> refund has been initiated to your payment method.
                    @endif
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" style="max-width:700px;margin:0 auto 1.5rem;">⚠ {{ session('error') }}</div>
            @endif
        </div>

        {{-- Page Header --}}
        <div class="page-header" style="text-align:center;margin-bottom:2.5rem;">
            @if($isCancelled)
                <div style="width:72px;height:72px;background:rgba(211,47,35,.15);border:2px solid rgba(211,47,35,.4);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:28px;color:var(--red);">✕</div>
                <h1 style="font-size:26px;font-weight:900;color:var(--red);margin-bottom:6px;">Booking Cancelled</h1>
            @elseif($isPartial)
                <div style="width:72px;height:72px;background:rgba(255,193,7,.12);border:2px solid rgba(255,193,7,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:28px;color:var(--yellow);">⚠</div>
                <h1 style="font-size:26px;font-weight:900;color:var(--yellow);margin-bottom:6px;">Partially Cancelled</h1>
            @else
                <div style="width:72px;height:72px;background:rgba(40,167,69,.15);border:2px solid rgba(40,167,69,.4);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:32px;color:var(--green);">✓</div>
                <h1 style="font-size:26px;font-weight:900;color:var(--green);margin-bottom:6px;">Booking Confirmed!</h1>
            @endif
            <p style="color:var(--text-3);font-size:14px;">
                {{ $booking->show->movie->title }} — {{ $booking->show->show_date->format('d M Y') }}
            </p>
        </div>

        {{-- TICKET CARD --}}
        <div class="print-only-wrap">
        <div id="ticketCard" style="max-width:700px;margin:0 auto 2rem;">
            <div style="display:flex;border-radius:14px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.85);">

                {{-- LEFT: Main ticket body --}}
                <div style="flex:1;position:relative;overflow:hidden;min-height:260px;background:linear-gradient(135deg,#7a0000,#4a0000);">
                    <div style="position:absolute;right:-30px;top:-30px;width:180px;height:180px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
                    <div style="position:absolute;right:20px;top:20px;width:110px;height:110px;background:rgba(255,255,255,.025);border-radius:50%;"></div>

                    <div style="position:relative;z-index:1;padding:24px 26px 22px;height:100%;display:flex;flex-direction:column;justify-content:space-between;">

                        {{-- Logo + Status badge --}}
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
                            <div style="font-size:34px;font-weight:900;color:#fff;line-height:1;letter-spacing:-1px;">
                                CINE<span style="color:#ea6b1d;">X</span>
                            </div>
                            @if($isCancelled)
                                <div style="background:rgba(0,0,0,.45);border:1px solid rgba(255,100,100,.35);border-radius:6px;padding:5px 13px;font-size:10px;font-weight:800;color:#ff8888;white-space:nowrap;letter-spacing:1px;">✕ CANCELLED</div>
                            @elseif($isPartial)
                                <div style="background:rgba(0,0,0,.45);border:1px solid rgba(255,200,0,.3);border-radius:6px;padding:5px 13px;font-size:10px;font-weight:800;color:#ffd700;white-space:nowrap;letter-spacing:1px;">⚠ PARTIAL</div>
                            @else
                                <div style="background:rgba(0,0,0,.45);border:1px solid rgba(255,255,255,.2);border-radius:6px;padding:5px 13px;font-size:10px;font-weight:800;color:#fff;white-space:nowrap;letter-spacing:1px;">✓ CONFIRMED</div>
                            @endif
                        </div>

                        {{-- Genre + Title --}}
                        <div style="margin-bottom:18px;">
                            <div style="font-size:11px;color:#ea6b1d;font-weight:700;letter-spacing:3px;text-transform:uppercase;margin-bottom:6px;">
                                {{ $booking->show->movie->genre }} &bull; {{ $booking->show->movie->duration_minutes }} MIN
                            </div>
                            <div style="font-size:28px;font-weight:900;color:#fff;line-height:1.05;text-transform:uppercase;letter-spacing:.5px;">
                                {{ $booking->show->movie->title }}
                            </div>
                        </div>

                        {{-- Info grid --}}
                        <div style="display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid rgba(255,255,255,.12);padding-top:12px;margin-bottom:14px;">
                            @foreach([
                                ['THEATER', $booking->show->theater->name],
                                ['DATE',    $booking->show->show_date->format('d M Y')],
                                ['TIME',    \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A')],
                                ['CLASS',   ucfirst($booking->seat_class)],
                            ] as $idx => $r)
                            <div style="{{ $idx>0?'border-left:1px solid rgba(255,255,255,.1);padding-left:10px;':'padding-right:8px;' }}">
                                <div style="font-size:9px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:2px;font-weight:700;margin-bottom:3px;">{{ $r[0] }}</div>
                                <div style="font-size:12px;font-weight:800;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r[1] }}</div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Dashed separator --}}
                        <div style="border-top:2px dashed rgba(255,255,255,.18);margin-bottom:16px;"></div>

                        {{-- Seats + Amount --}}
                        <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:flex-end;">
                                @foreach($booking->active_seats as $seat)
                                <div>
                                    <div style="font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:2px;margin-bottom:2px;">SEAT</div>
                                    <div style="font-size:26px;font-weight:900;color:#fff;font-family:'Courier New',monospace;line-height:1;">{{ $seat }}</div>
                                </div>
                                @endforeach
                                @if(count($booking->cancelled_seats ?? []) > 0)
                                <div style="border-left:1px solid rgba(255,255,255,.12);padding-left:14px;">
                                    @foreach($booking->cancelled_seats as $seat)
                                    <div style="font-size:16px;font-weight:700;color:rgba(255,100,100,.5);font-family:'Courier New',monospace;text-decoration:line-through;line-height:1.5;">{{ $seat }}</div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:2px;margin-bottom:3px;">AMOUNT PAID</div>
                                <div style="font-size:26px;font-weight:900;color:#ea6b1d;">Rs.{{ number_format($currentAmount) }}</div>
                                @if($refundedAmount > 0)
                                <div style="font-size:10px;color:rgba(40,167,69,.8);margin-top:3px;">Rs.{{ number_format($refundedAmount) }} refunded</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TEAR LINE --}}
                <div style="width:22px;flex-shrink:0;background:rgba(0,0,0,.5);position:relative;display:flex;align-items:center;justify-content:center;">
                    <div style="position:absolute;top:-11px;left:50%;transform:translateX(-50%);width:22px;height:22px;background:#050000;border-radius:50%;"></div>
                    <div style="width:1px;height:100%;background:repeating-linear-gradient(to bottom,transparent,transparent 5px,rgba(255,255,255,.2) 5px,rgba(255,255,255,.2) 9px);"></div>
                    <div style="position:absolute;bottom:-11px;left:50%;transform:translateX(-50%);width:22px;height:22px;background:#050000;border-radius:50%;"></div>
                </div>

                {{-- STUB RIGHT --}}
                <div style="width:130px;flex-shrink:0;background:#3a0000;display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding:18px 10px;overflow:hidden;">
                    <div style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);text-align:center;">
                        <div style="font-size:10px;color:rgba(255,255,255,.3);letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;">{{ $booking->show->show_date->format('d M Y') }}</div>
                        <div style="font-size:13px;font-weight:900;color:rgba(255,255,255,.75);text-transform:uppercase;letter-spacing:1px;">
                            {{ mb_strimwidth($booking->show->movie->title, 0, 13, '...') }}
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <div style="font-size:8px;color:rgba(255,255,255,.25);text-transform:uppercase;letter-spacing:2px;writing-mode:vertical-rl;">ADMISSION NO.</div>
                        <div style="font-family:'Courier New',monospace;font-size:9px;font-weight:700;color:#ea6b1d;writing-mode:vertical-rl;letter-spacing:1px;">{{ $booking->booking_id }}</div>
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:center;gap:5px;">
                        @php
                            $bn   = preg_replace('/[^0-9]/', '', $booking->booking_id);
                            $bLen = max(1, strlen($bn));
                        @endphp
                        <div style="display:flex;gap:1px;height:46px;align-items:flex-end;">
                            @for($bi = 0; $bi < 22; $bi++)
                                @php $bh = max(4, (intval($bn[$bi % $bLen]) + $bi) % 9 + 6); @endphp
                                <div style="width:{{ $bi%3===0?'2':'1.5' }}px;height:{{ $bh*2 }}px;background:rgba(255,255,255,{{ $bi%2===0?'.85':'.35' }});border-radius:1px;"></div>
                            @endfor
                        </div>
                        <div style="font-family:'Courier New',monospace;font-size:7px;color:rgba(255,255,255,.3);letter-spacing:1px;">{{ substr($bn, 0, 10) }}</div>
                    </div>
                </div>

            </div>

            {{-- Bottom strip --}}
            <div style="background:rgba(0,0,0,.8);border:1px solid rgba(255,255,255,.05);border-top:none;border-radius:0 0 14px 14px;padding:8px 22px;display:flex;justify-content:space-between;align-items:center;">
                <div style="font-size:10px;color:rgba(255,255,255,.25);">cinex.pk &bull; Karachi's Premier Cinema</div>
                <div style="font-size:10px;color:rgba(255,255,255,.25);">{{ $booking->show->movie->age_rating ?? 'PG-13' }} &bull; Booked: {{ $booking->created_at->format('d M Y') }}</div>
            </div>
        </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-btns no-print" style="max-width:700px;margin:0 auto 1.5rem;display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
            <button onclick="window.print()"
                style="background:var(--surface-2);border:1px solid var(--border-2);color:#fff;padding:12px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;font-family:var(--font-body);display:flex;align-items:center;justify-content:center;gap:6px;"
                onmouseover="this.style.borderColor='var(--red)';this.style.color='var(--red)'"
                onmouseout="this.style.borderColor='var(--border-2)';this.style.color='#fff'">
                🖨️ Print Ticket
            </button>
            <a href="{{ route('bookings.history') }}"
               style="background:var(--surface-2);border:1px solid var(--border-2);color:#fff;padding:12px;border-radius:8px;font-size:13px;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;">
                My Bookings
            </a>
            <a href="{{ route('movies.index') }}" class="btn btn-primary"
               style="text-align:center;padding:12px;font-size:13px;display:flex;align-items:center;justify-content:center;">
                Book More
            </a>
        </div>

        {{-- Cancel Section --}}
        @if($canCancel)
        <div style="max-width:700px;margin:0 auto;" id="cancelSection" class="no-print">
            <div style="background:rgba(255,193,7,.05);border:1px solid rgba(255,193,7,.18);border-radius:12px;padding:1.25rem 1.5rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:14px;font-weight:700;color:var(--yellow);margin-bottom:3px;">⚠ Cancel Seats</div>
                        <div style="font-size:12px;color:var(--text-3);">Select seats to cancel — up to 1 hour before show.</div>
                    </div>
                    <button onclick="toggleCancelForm()" id="toggleBtn"
                        style="background:rgba(255,193,7,.1);border:1px solid rgba(255,193,7,.3);color:var(--yellow);padding:7px 14px;border-radius:6px;font-size:12px;font-weight:700;cursor:pointer;font-family:var(--font-body);white-space:nowrap;">
                        Select Seats
                    </button>
                </div>

                <div id="cancelForm" style="display:none;margin-top:1rem;">
                    <form method="POST" id="cancelFormEl" action="{{ route('booking.cancel-seats', $booking->id) }}">
                        @csrf
                        @method('PATCH')
                        <div style="margin-bottom:1rem;">
                            <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:10px;">Tap to select seats:</div>
                            <div style="display:flex;flex-wrap:wrap;gap:10px;">
                                @foreach($booking->active_seats as $seat)
                                <label style="cursor:pointer;display:block;">
                                    <input type="checkbox" name="cancel_seats[]" value="{{ $seat }}" class="seat-cancel-cb" style="display:none;">
                                    <div class="cancel-seat-btn"
                                         style="padding:10px 18px;border-radius:8px;font-family:var(--font-mono);font-size:15px;font-weight:700;border:1px solid #2a2a2a;background:#1a1a1a;color:#b0b0b0;transition:all .2s;user-select:none;text-align:center;min-width:64px;">
                                        {{ $seat }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div id="cancelSummary" style="display:none;background:rgba(211,47,35,.08);border:1px solid rgba(211,47,35,.2);border-radius:8px;padding:10px 14px;margin-bottom:1rem;font-size:13px;color:var(--text-2);">
                            Cancelling: <span id="cancelSeatList" style="color:var(--red);font-weight:700;font-family:var(--font-mono);"></span>
                            <span id="refundPreview" style="color:var(--green);margin-left:8px;font-weight:700;"></span>
                        </div>
                        <button type="submit" id="cancelSubmitBtn" disabled
                            style="width:100%;background:rgba(211,47,35,.12);border:1px solid rgba(211,47,35,.25);color:var(--red);padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:not-allowed;opacity:.4;transition:all .25s;font-family:var(--font-body);">
                            Cancel Selected Seats
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @elseif(!$isCancelled)
        <div class="no-print" style="max-width:700px;margin:0 auto;text-align:center;padding-top:.5rem;">
            <p style="font-size:12px;color:var(--text-4);">Cancellation not available — show is within 1 hour or has passed.</p>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
var UNIT_PRICE = {{ $unitPrice }};
var KIDS_COUNT = {{ $booking->kids_count ?? 0 }};
// Print ticket — only ticket card
function printTicket() {
    var ticketHTML = document.getElementById('ticketCard').outerHTML;
    var win = window.open('', '_blank', 'width=900,height=600');
    win.document.write(`
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CineX Ticket — {{ $booking->booking_id }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body {
    background: #050000;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    font-family: Inter, Arial, sans-serif;
    padding: 30px;
}
/* Resolve CSS variables */
[style] { }
</style>
<script>
window.onload = function() {
    // Replace CSS variables with real values
    document.querySelectorAll('[style]').forEach(function(el) {
        var s = el.getAttribute('style') || '';
        s = s.replace(/var\(--red\)/g,       '#d32f23')
             .replace(/var\(--orange\)/g,    '#ea6b1d')
             .replace(/var\(--green\)/g,     '#28a745')
             .replace(/var\(--yellow\)/g,    '#ffc107')
             .replace(/var\(--black\)/g,     '#000000')
             .replace(/var\(--white\)/g,     '#ffffff')
             .replace(/var\(--surface-1\)/g, '#0d0d0d')
             .replace(/var\(--surface-2\)/g, '#111111')
             .replace(/var\(--surface-3\)/g, '#1a1a1a')
             .replace(/var\(--border-1\)/g,  '#1e1e1e')
             .replace(/var\(--border-2\)/g,  '#2a2a2a')
             .replace(/var\(--text-2\)/g,    '#b0b0b0')
             .replace(/var\(--text-3\)/g,    '#777777')
             .replace(/var\(--font-mono\)/g, 'Courier New, monospace')
             .replace(/var\(--font-body\)/g, 'Inter, Arial, sans-serif');
        el.setAttribute('style', s);
    });
    setTimeout(function() { window.print(); }, 500);
};
<\/script>
</head>
<body>
${ticketHTML}
</body>
</html>`);
    win.document.close();
}

// Cancel form toggle
function toggleCancelForm() {
    var form = document.getElementById('cancelForm');
    var btn  = document.getElementById('toggleBtn');
    if (!form || !btn) return;
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        btn.textContent = '▲ Hide';
        document.querySelectorAll('.seat-cancel-cb').forEach(function(cb){ cb.checked=false; });
        document.querySelectorAll('.cancel-seat-btn').forEach(function(d){
            d.style.background='#1a1a1a'; d.style.borderColor='#2a2a2a';
            d.style.color='#b0b0b0'; d.style.transform='scale(1)';
        });
        updateCancelBtn();
    } else {
        form.style.display = 'none';
        btn.textContent = 'Select Seats';
    }
}

function updateCancelBtn() {
    var checked  = document.querySelectorAll('.seat-cancel-cb:checked');
    var btn      = document.getElementById('cancelSubmitBtn');
    var summary  = document.getElementById('cancelSummary');
    var seatList = document.getElementById('cancelSeatList');
    if (!btn) return;
    if (checked.length > 0) {
        var seats = Array.from(checked).map(function(c){ return c.value; });
        if (seatList) seatList.textContent = seats.join(', ');
        if (summary)  summary.style.display = 'block';
        btn.disabled=false; btn.style.opacity='1'; btn.style.cursor='pointer';
        btn.style.background='rgba(211,47,35,.22)';
        btn.style.borderColor='rgba(211,47,35,.5)';
        btn.textContent='Cancel '+checked.length+' Seat(s)';
    } else {
        if (summary) summary.style.display='none';
        btn.disabled=true; btn.style.opacity='.4'; btn.style.cursor='not-allowed';
        btn.style.background='rgba(211,47,35,.1)';
        btn.textContent='Cancel Selected Seats';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cancel-seat-btn').forEach(function(div) {
        div.addEventListener('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            var label = div.closest('label');
            if (!label) return;
            var cb = label.querySelector('.seat-cancel-cb');
            if (!cb) return;
            cb.checked = !cb.checked;
            if (cb.checked) {
                div.style.background='rgba(211,47,35,0.28)';
                div.style.borderColor='#d32f23';
                div.style.color='#fff';
                div.style.transform='scale(1.07)';
            } else {
                div.style.background='#1a1a1a';
                div.style.borderColor='#2a2a2a';
                div.style.color='#b0b0b0';
                div.style.transform='scale(1)';
            }
            updateCancelBtn();
        });
    });

    var cancelFormEl = document.getElementById('cancelFormEl');
    if (cancelFormEl) {
        cancelFormEl.addEventListener('submit', function(e) {
            var checked = document.querySelectorAll('.seat-cancel-cb:checked');
            if (checked.length === 0) { e.preventDefault(); return false; }
            return true;
        });
    }
});
</script>
@endpush
@endsection