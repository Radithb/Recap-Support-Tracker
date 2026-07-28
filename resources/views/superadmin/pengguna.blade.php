@extends('layouts.app')

@section('page_title', 'Manajemen Pengguna')
@section('page_subtitle', 'Fitur Eksklusif Super Admin')

@section('content')
<div class="pelapor-panel">
    <div class="glass-panel fade-up" style="padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--ink);">Daftar Pengguna Sistem</h2>
            <button class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Pengguna
            </button>
        </div>

        <div style="text-align: center; padding: 40px 20px; color: var(--ink-soft); border: 1px dashed var(--line); border-radius: 12px; margin-top: 24px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 16px; opacity: 0.5;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Manajemen Pengguna (Coming Soon)</h3>
            <p style="font-size: 0.9rem; max-width: 400px; margin: 0 auto; line-height: 1.5;">Halaman ini disiapkan khusus untuk Super Admin mengelola akun Koperasi (Pelapor) dan Tim Support.</p>
        </div>
    </div>
</div>
@endsection
