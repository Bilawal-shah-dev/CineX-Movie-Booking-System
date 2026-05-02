@extends('layouts.app')
@section('title', 'Payment — CineX')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;background:radial-gradient(ellipse at 50% 0%,rgba(211,47,35,.07) 0%,transparent 60%);">
    <div style="width:100%;max-width:480px;">

        <div style="text-align:center;margin-bottom:2rem;">
            <h1 style="font-size:26px;font-weight:800;margin-bottom:6px;">Secure Payment</h1>
            <p style="color:var(--text-3);font-size:14px;">
                Rs. <strong style="color:var(--orange);font-size:20px;">{{ number_format($bookingData['total_amount']) }}</strong>
                — {{ $show->movie->title }}
            </p>
        </div>

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:1.25rem;">
                ⚠ {{ $errors->first() }}
            </div>
        @endif

        <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-lg);padding:2rem;">

            {{-- Tabs --}}
            <div style="display:flex;background:var(--surface-3);border-radius:8px;padding:4px;margin-bottom:1.75rem;gap:4px;">
                @foreach(['jazzcash'=>'JazzCash','easypaisa'=>'EasyPaisa','card'=>'Card'] as $val=>$label)
                <button type="button" class="pay-tab" data-method="{{ $val }}"
                    style="flex:1;padding:9px 6px;background:{{ $val==='jazzcash'?'var(--red)':'transparent' }};color:{{ $val==='jazzcash'?'#fff':'var(--text-3)' }};border:none;border-radius:6px;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;font-family:var(--font-body);"
                    onclick="selectMethod('{{ $val }}')">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <form method="POST" action="{{ route('payment.process') }}">
                @csrf
                <input type="hidden" name="payment_method" id="paymentMethodInput" value="jazzcash">

                {{-- JazzCash --}}
                <div id="panel-jazzcash">
                    <div style="background:rgba(211,47,35,.06);border:1px solid rgba(211,47,35,.15);border-radius:8px;padding:10px 14px;margin-bottom:1.25rem;font-size:12px;color:var(--text-2);">
                        🔴 JazzCash — Enter your registered mobile number and PIN
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number *</label>
                        <input type="text" name="jz_phone" class="form-control"
                               placeholder="03XX-XXXXXXX" maxlength="15"
                               value="{{ old('jz_phone') }}" required>
                        @error('jz_phone')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">4-Digit MPIN *</label>
                        <input type="password" name="jz_pin" class="form-control"
                               placeholder="••••" maxlength="4" pattern="\d{4}"
                               value="{{ old('jz_pin') }}" required>
                        @error('jz_pin')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- EasyPaisa --}}
                <div id="panel-easypaisa" style="display:none;">
                    <div style="background:rgba(40,167,69,.06);border:1px solid rgba(40,167,69,.15);border-radius:8px;padding:10px 14px;margin-bottom:1.25rem;font-size:12px;color:var(--text-2);">
                        🟢 EasyPaisa — Enter your registered mobile number and PIN
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number *</label>
                        <input type="text" name="ep_phone" class="form-control"
                               placeholder="03XX-XXXXXXX" maxlength="15"
                               value="{{ old('ep_phone') }}">
                        @error('ep_phone')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">4-Digit PIN *</label>
                        <input type="password" name="ep_pin" class="form-control"
                               placeholder="••••" maxlength="4" pattern="\d{4}"
                               value="{{ old('ep_pin') }}">
                        @error('ep_pin')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Card --}}
                <div id="panel-card" style="display:none;">
                    <div class="form-group">
                        <label class="form-label">Card Number *</label>
                        <input type="text" name="card_number" class="form-control"
                               placeholder="XXXX XXXX XXXX XXXX" maxlength="19"
                               value="{{ old('card_number') }}"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/(.{4})/g,'$1 ').trim()">
                        @error('card_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group">
                            <label class="form-label">Expiry *</label>
                            <input type="text" name="card_expiry" class="form-control"
                                   placeholder="MM/YY" maxlength="5"
                                   value="{{ old('card_expiry') }}"
                                   oninput="formatExpiry(this)">
                            @error('card_expiry')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">CVV *</label>
                            <input type="password" name="card_cvv" class="form-control"
                                   placeholder="•••" maxlength="3" pattern="\d{3}"
                                   value="{{ old('card_cvv') }}">
                            @error('card_cvv')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cardholder Name *</label>
                        <input type="text" name="card_name" class="form-control"
                               placeholder="As on card" value="{{ old('card_name') }}">
                        @error('card_name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Pay Button --}}
                <button type="submit"
                    style="width:100%;background:var(--red);color:#fff;padding:14px;border-radius:8px;font-size:16px;font-weight:800;border:none;cursor:pointer;transition:all .25s;font-family:var(--font-body);box-shadow:0 4px 20px rgba(211,47,35,.4);margin-top:.5rem;"
                    onmouseover="this.style.background='#b52a1e';this.style.boxShadow='0 6px 28px rgba(211,47,35,.6)'"
                    onmouseout="this.style.background='var(--red)';this.style.boxShadow='0 4px 20px rgba(211,47,35,.4)'">
                    Pay Rs. {{ number_format($bookingData['total_amount']) }}
                </button>

                <p style="text-align:center;font-size:11px;color:var(--text-4);margin-top:10px;">
                    🔒 Demo payment system. No real transaction will occur.
                </p>
            </form>
        </div>

        <a href="{{ route('booking.summary.show') }}"
           style="display:block;text-align:center;margin-top:1rem;font-size:13px;color:var(--text-3);"
           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-3)'">
            ← Back to Summary
        </a>
    </div>
</div>

@push('scripts')
<script>
function selectMethod(method) {
    document.getElementById('paymentMethodInput').value = method;
    ['jazzcash','easypaisa','card'].forEach(function(m) {
        var tab   = document.querySelector('[data-method="'+m+'"]');
        var panel = document.getElementById('panel-'+m);
        var active = m === method;
        tab.style.background = active ? 'var(--red)' : 'transparent';
        tab.style.color      = active ? '#fff' : 'var(--text-3)';
        if (panel) panel.style.display = active ? 'block' : 'none';
    });
}

function formatExpiry(input) {
    var v = input.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 3) {
        input.value = v.substring(0,2) + '/' + v.substring(2);
    } else {
        input.value = v;
    }
}
</script>
@endpush
@endsection