@extends('layouts.app')

@section('content')

<div class="pelapor-panel active">

<div class="content-wrap" id="actual-content">

@section('page_title', __('messages.recap_template_surat'))
@section('page_subtitle', 'internal.ptskk.id')

<div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 2rem; color: var(--ink); font-family: 'Poppins', sans-serif; font-weight: 700;">{{ __('messages.recap_template_surat') }}</h1>

    </div>
</div>

{{-- FILTER CARD (KOSONG SEMENTARA) --}}
<div class="glass-panel fade-up" style="animation-delay: 0.15s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;">
    <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">{{ __('messages.filter') }}</p>
</div>

{{-- TABLE CARD (KOSONG SEMENTARA) --}}
<div class="glass-panel fade-up" style="animation-delay: 0.2s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line); flex-wrap: wrap; gap: 15px;">
        <h3 style="margin: 0; font-size: 1.1rem; color: var(--ink); font-family: 'Poppins', sans-serif; font-weight: 700;">{{ __('messages.riwayat_penggunaan_surat') }}</h3>
    </div>
    
    <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
        {{ __('messages.no_data_template_surat') }}
    </div>
</div>

</div>
</div>
@endsection
