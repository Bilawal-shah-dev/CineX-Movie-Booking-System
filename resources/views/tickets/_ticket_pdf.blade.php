{{-- PDF-ready ticket for Booking --}}
@php
    $isCancelled = $booking->status === 'cancelled';
    $isPartial = $booking->isPartiallyCancelled();
@endphp

<div style="font-family:'Arial',sans-serif;max-width:660px;margin:0 auto;border-radius:14px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.85);">
    {{-- LEFT: Main ticket --}}
    <div style="flex:1;position:relative;overflow:hidden;min-height:260px;background:#6b0000;">
        {{-- Background image --}}
        <div style="position:absolute;inset:0;">
            <img src="{{ $bg }}" alt="BG" style="width:100%;height:100%;object-fit:cover;opacity:.15;">
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(120,0,0,.97),rgba(70,0,0,.98));"></div>
        </div>

        <div style="position:relative;z-index:1;padding:22px 24px 20px;height:100%;display:flex;flex-direction:column;justify-content:space-between;">
            {{-- Logo + Status --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
                <div style="font-size:32px;font-weight:900;color:#fff;line-height:1;letter-spacing:-.02em;">
                    CINE<span style="color:#ff7f50;">X</span>
                </div>
                <div style="background:rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.2);border-radius:6px;padding:5px 12px;font-size:10px;font-weight:800;color:#fff;white-space:nowrap;">
                    @if($isCancelled)
                        ✕ CANCELLED
                    @elseif($isPartial)
                        ⚠ PARTIAL
                    @else
                        ✓ CONFIRMED
                    @endif
                </div>
            </div>

            {{-- Movie Info --}}
            <div style="margin-bottom:16px;">
                <div style="font-size:11px;color:#ffa500;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:5px;">
                    {{ $booking->show->movie->genre }} &bull; {{ $booking->show->movie->duration_minutes }} MIN
                </div>
                <div style="font-size:25px;font-weight:900;color:#fff;line-height:1.05;text-transform:uppercase;">
                    {{ $booking->show->movie->title }}
                </div>
            </div>

            {{-- Info Row --}}
            <div style="display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid rgba(255,255,255,.12);padding-top:12px;margin-bottom:14px;">
                @foreach([
                    ['THEATER', $booking->show->theater->name],
                    ['DATE', $booking->show->show_date->format('d M Y')],
                    ['TIME', \Carbon\Carbon::parse($booking->show->show_time)->format('h:i A')],
                    ['CLASS', ucfirst($booking->seat_class)]
                ] as $idx => $r)
                    <div style="{{ $idx>0?'border-left:1px solid rgba(255,255,255,.1);padding-left:10px;':'padding-right:8px;' }}">
                        <div style="font-size:9px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.1em;font-weight:700;margin-bottom:3px;">{{ $r[0] }}</div>
                        <div style="font-size:11px;font-weight:800;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r[1] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Seats + Amount --}}
            <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div style="display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;">
                    @foreach($booking->active_seats as $seat)
                        <div>
                            <div style="font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;margin-bottom:2px;">SEAT</div>
                            <div style="font-size:22px;font-weight:900;color:#fff;font-family:'Courier New',monospace;line-height:1;">{{ $seat }}</div>
                        </div>
                    @endforeach
                    @if(count($booking->cancelled_seats ?? []) > 0)
                        <div style="border-left:1px solid rgba(255,255,255,.12);padding-left:14px;">
                            @foreach($booking->cancelled_seats as $seat)
                                <div style="font-size:14px;font-weight:700;color:rgba(255,100,100,.5);font-family:'Courier New',monospace;text-decoration:line-through;line-height:1.5;">{{ $seat }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div style="text-align:right;">
                    <div style="font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px;">AMOUNT PAID</div>
                    <div style="font-size:22px;font-weight:900;color:#ffa500;">Rs.{{ number_format($booking->total_amount) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dummy Barcode --}}
<div style="margin-top:14px;text-align:center;">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/dummy-barcode.png'))) }}" 
         alt="Barcode" style="height:50px;">
</div>

    {{-- Bottom Strip --}}
    <div style="background:rgba(0,0,0,.75);border:1px solid rgba(255,255,255,.05);border-top:none;border-radius:0 0 14px 14px;padding:7px 20px;display:flex;justify-content:space-between;align-items:center;font-size:10px;color:rgba(255,255,255,.2);">
        <div>cinex.pk &bull; Karachi's Premier Cinema</div>
        <div>{{ $booking->show->movie->age_rating ?? 'PG-13' }} &bull; Booked: {{ $booking->created_at->format('d M Y') }}</div>
    </div>
</div>