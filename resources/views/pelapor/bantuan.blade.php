@extends('layouts.app')

@section('page_title', 'Pusat Bantuan')
@section('page_subtitle', 'PELAPOR')

@section('content')
<div class="pelapor-panel">
    <div style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 24px;">
        <h3 style="margin-top: 0; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; font-family: var(--font-display); font-size: 19px; font-weight: 600; color: var(--ink);">
            <span>💬</span> Hubungi Tim Support
        </h3>
        <p style="color: var(--ink-soft); font-size: 14px; margin-bottom: 24px; margin-top: 0;">
            Butuh bantuan cepat di luar tiket? Sapa kami lewat kanal berikut.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            <!-- Telepon -->
            <div style="border: 1px solid var(--line); border-radius: 10px; padding: 16px; display: flex; align-items: center; gap: 16px;">
                <div style="background: var(--brand-primary-soft); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('telephone.png') }}" alt="Telepon" style="width: 22px; height: 22px; object-fit: contain;">
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 14px; color: var(--ink);">Telepon</div>
                    <div style="font-family: var(--font-mono); font-size: 13px; color: var(--ink-soft); margin-top: 4px;">+62 22 8888 0101</div>
                </div>
            </div>
            
            <!-- Email -->
            <div style="border: 1px solid var(--line); border-radius: 10px; padding: 16px; display: flex; align-items: center; gap: 16px;">
                <div style="background: var(--brand-primary-soft); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('mail.png') }}" alt="Email" style="width: 22px; height: 22px; object-fit: contain;">
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 14px; color: var(--ink);">Email</div>
                    <div style="font-family: var(--font-mono); font-size: 13px; color: var(--ink-soft); margin-top: 4px;">support@saktikinerja.id</div>
                </div>
            </div>
            
            <!-- WhatsApp -->
            <div style="border: 1px solid var(--line); border-radius: 10px; padding: 16px; display: flex; align-items: center; gap: 16px;">
                <div style="background: var(--brand-primary-soft); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('whatsapp.png') }}" alt="WhatsApp" style="width: 22px; height: 22px; object-fit: contain;">
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 14px; color: var(--ink);">WhatsApp</div>
                    <div style="font-family: var(--font-mono); font-size: 13px; color: var(--ink-soft); margin-top: 4px;">+62 812 3456 7890</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
