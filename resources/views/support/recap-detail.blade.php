@extends('layouts.app')

@section('page_title', 'Laporan Detail Support')
@section('page_subtitle', 'internal.ptskk.id')

@section('content')
<div class="pelapor-panel active fade-up" style="animation-delay: 0.1s;">
    <div class="glass-panel" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 4rem 2rem; text-align: center; margin-top: 2rem;">
        <div style="display: inline-flex; justify-content: center; align-items: center; width: 64px; height: 64px; background: var(--paper-sunken); border-radius: 50%; margin-bottom: 1.5rem;">
            <span style="display:inline-block; width: 32px; height: 32px; background-color: var(--brand-primary); -webkit-mask-image: url('{{ asset('application.png') }}'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; mask-image: url('{{ asset('application.png') }}'); mask-size: contain; mask-repeat: no-repeat;"></span>
        </div>
        <h2 style="color: var(--ink); font-size: 1.5rem; margin-bottom: 0.5rem; font-weight: 700;">Tahap ini masih dalam proses</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 400px; margin: 0 auto 2rem auto; line-height: 1.6;">Halaman detail laporan bulanan sedang dalam tahap pengembangan dan akan segera tersedia.</p>
        <a href="{{ route('support.recap') }}" class="btn btn-primary" style="padding: 10px 24px; font-weight: 600; text-decoration: none;">Kembali ke Rekap Support</a>
    </div>
</div>
@endsection
