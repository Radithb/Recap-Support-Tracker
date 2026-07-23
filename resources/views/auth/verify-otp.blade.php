@extends('layouts.app')

@section('content')
<div class="login-wrap" style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; background: #ffffff;">
    
    {{-- Top Header Logo --}}
    <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 28px; text-decoration: none;" class="fade-up">
        <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain;">
        <div>
            <h2 style="margin: 0; font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--ink); line-height: 1.2;">Recap Support Tracker</h2>
            <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--ink-soft); letter-spacing: 1px; text-transform: uppercase;">PT SAKTI KINERJA KOLABORASINDO</div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="login-panel-card fade-up" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 24px; padding: 36px 32px; max-width: 460px; width: 100%; box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08); text-align: center; position: relative;">
        
        {{-- Back link --}}
        <div style="margin-bottom: 24px; text-align: center;">
            <a href="{{ route('password.request') }}" style="color: #475569; font-weight: 600; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='#475569'">
                &larr; Ubah Email
            </a>
        </div>

        {{-- Envelope Icon --}}
        <div style="font-size: 36px; margin-bottom: 16px; line-height: 1;">
            📩
        </div>

        {{-- Eyebrow --}}
        <div style="font-family: var(--font-mono); font-size: 11px; font-weight: 700; color: #17447e; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px;">
            VERIFIKASI KODE OTP
        </div>

        {{-- Heading --}}
        <h1 style="font-family: var(--font-display); font-size: 26px; font-weight: 700; color: var(--ink); margin: 0 0 12px 0; line-height: 1.2;">
            Masukkan Kode OTP
        </h1>

        {{-- Subtitle Description --}}
        <p style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.6; margin: 0 0 20px 0; max-width: 380px; margin-left: auto; margin-right: auto;">
            Kami telah mengirimkan 6 digit kode verifikasi ke email <strong>{{ session('reset_email') }}</strong>
        </p>

        {{-- Demo OTP Banner --}}
        @if(session('info_otp'))
            <div style="background: #e0f2fe; color: #0369a1; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #bae6fd;">
                ⚡ {{ session('info_otp') }}
            </div>
        @endif

        {{-- Error message --}}
        @if($errors->any())
            <div id="otp-error" class="alert-dismiss" style="text-align: left; margin-bottom: 18px; font-size: 13px; font-weight: 500; color: #dc2626; background: #fee2e2; padding: 10px 14px; border-radius: 8px; border: 1px solid #fca5a5;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- OTP Form --}}
        <form action="{{ route('password.verify_otp') }}" method="POST" style="text-align: center;">
            @csrf
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink-soft); margin-bottom: 12px;">6 Digit Kode Verifikasi</label>
                
                {{-- 6 individual OTP input boxes --}}
                <div style="display: flex; gap: 8px; justify-content: center; margin-bottom: 8px;" id="otp-box-wrap">
                    @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" pattern="[0-9]*" inputmode="numeric" class="otp-digit-box" data-index="{{ $i }}" style="width: 46px; height: 52px; text-align: center; font-size: 22px; font-weight: 700; font-family: var(--font-mono); border: 2px solid var(--line); border-radius: 10px; background: var(--paper-raised); color: var(--ink); outline: none; transition: border-color 0.2s, box-shadow 0.2s;" onfocus="this.style.borderColor='#17447e'" onblur="this.style.borderColor='var(--line)'">
                    @endfor
                </div>

                {{-- Hidden single input --}}
                <input type="hidden" name="otp" id="real-otp-input" value="{{ old('otp') }}" required>
            </div>

            <button type="submit" class="btn" style="width: 100%; justify-content: center; background: #17447e; border: none; color: white; padding: 12px 16px; border-radius: 10px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 14px rgba(23, 68, 126, 0.35); transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='#123566'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#17447e'; this.style.transform='translateY(0)';">
                Verifikasi Kode
            </button>
        </form>

        {{-- Resend OTP form --}}
        <div style="margin-top: 24px; font-size: 13px; color: var(--ink-soft);">
            Tidak menerima kode? 
            <form action="{{ route('password.resend_otp') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #17447e; font-weight: 700; cursor: pointer; padding: 0; text-decoration: underline;">Kirim ulang</button>
            </form>
        </div>

    </div>

    {{-- Bottom Brand Footer --}}
    <div style="margin-top: 32px; font-family: var(--font-mono); font-size: 11px; font-weight: 600; color: var(--ink-soft); letter-spacing: 2px; text-transform: uppercase; display: flex; gap: 24px; opacity: 0.7;">
        <span>SAKTI ONLINE</span>
        <span>SICUNDO</span>
        <span>ISO 27001:2022</span>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const boxes = document.querySelectorAll('.otp-digit-box');
    const realInput = document.getElementById('real-otp-input');

    function updateRealInput() {
        let val = '';
        boxes.forEach(box => val += box.value);
        realInput.value = val;
    }

    boxes.forEach((box, index) => {
        box.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value && index < boxes.length - 1) {
                boxes[index + 1].focus();
            }
            updateRealInput();
        });

        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                boxes[index - 1].focus();
            }
        });

        box.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            pasteData.split('').forEach((char, i) => {
                if (boxes[i]) {
                    boxes[i].value = char;
                }
            });
            if (boxes[Math.min(pasteData.length, boxes.length - 1)]) {
                boxes[Math.min(pasteData.length, boxes.length - 1)].focus();
            }
            updateRealInput();
        });
    });

    if (boxes[0]) boxes[0].focus();
});
</script>
@endsection
