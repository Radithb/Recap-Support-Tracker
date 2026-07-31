@extends('layouts.app')

@section('page_title', 'Detail Implementasi')
@section('page_subtitle', $implementasi->instansi->nama_instansi ?? 'Koperasi')

@section('topbar_right')
    <a href="{{ route('implementasi.index') }}" style="background-color: #64748b; color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: background 0.2s;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
    </a>
@endsection

@section('content')
<style>
    /* Styling Dasar & Header */
    .detail-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .impl-number {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }
    
    /* Dynamic Badge Sama dengan Index */
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-abu { background-color: #e2e8f0; color: #475569; }
    .badge-biru { background-color: #dbeafe; color: #1d4ed8; }
    .badge-kuning { background-color: #fef08a; color: #854d0e; }
    .badge-oranye { background-color: #ffedd5; color: #c2410c; }
    .badge-merah { background-color: #fee2e2; color: #b91c1c; }
    .badge-hijau { background-color: #dcfce3; color: #166534; }

    /* Sub-Sidebar Layout (Master Data Style) */
    .md-layout {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-top: 20px;
    }
    .md-sidebar {
        width: 240px;
        flex-shrink: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .md-tab-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 8px;
        background: transparent;
        border: none;
        color: #64748b;
        font-family: inherit;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
        width: 100%;
    }
    .md-tab-btn:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .md-tab-btn.active {
        background: #eff6ff;
        color: #2563eb;
        position: relative;
    }
    .md-tab-btn.active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 50%;
        background: #2563eb;
        border-radius: 0 4px 4px 0;
    }
    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    .tab-content.active {
        display: block;
    }
    @media (max-width: 768px) {
        .md-layout {
            flex-direction: column;
        }
        .md-sidebar {
            width: 100%;
        }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Grid Ringkasan */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    @media (max-width: 992px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
    .summary-item {
        background: #f8fafc;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .summary-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .summary-value {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
    }

    /* Checklist Table */
    .checklist-table {
        width: 100%;
        border-collapse: collapse;
    }
    .checklist-table th, .checklist-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .checklist-table th {
        background: #f8fafc;
        font-weight: 600;
        font-size: 14px;
    }
    .checklist-select {
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        width: 100%;
    }
    .checklist-input {
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        width: 100%;
    }

    /* Timeline Log */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -24px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #2563eb;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #2563eb;
    }
    .timeline-time {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .timeline-content {
        background: #f8fafc;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: var(--sage-soft, #d1fae5);
        color: var(--sage, #065f46);
        border: 1px solid rgba(46, 125, 82, 0.2);
        padding: 12px 14px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(20px);
        opacity: 0;
        transition: opacity 0.6s ease, transform 0.6s ease;
        z-index: 9999;
        font-size: calc(13.5px * var(--text-scale, 1));
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-width: 250px;
    }
    .toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    /* Progress bar in header */
    .progress-wrapper {
        flex-grow: 1;
        max-width: 300px;
    }
    .progress-bar-bg {
        width: 100%;
        background-color: #e2e8f0;
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        background-color: #2563eb;
        transition: width 0.5s ease-in-out;
    }

    /* Dark Mode Adjustments */
    .dark-mode .detail-card, .dark-mode .summary-item, .dark-mode .timeline-content {
        background: #1e293b;
        border-color: #334155;
    }
    .dark-mode .impl-number, .dark-mode .summary-value { color: #f8fafc; }
    .dark-mode .checklist-table th { background: #0f172a; color: #f8fafc; border-color: #334155; }
    .dark-mode .checklist-table td, .dark-mode .tabs-nav { border-color: #334155; }
    .dark-mode .checklist-input, .dark-mode .checklist-select { background: #0f172a; color: white; border-color: #334155; }
    .dark-mode .timeline::before { background: #334155; }
    .dark-mode .progress-bar-bg { background-color: #334155; }
</style>

@php
    $statusText = strtolower($implementasi->status);
    $badgeClass = 'badge-abu';
    if (str_contains($statusText, 'dijadwalkan')) $badgeClass = 'badge-biru';
    elseif (str_contains($statusText, 'menunggu')) $badgeClass = 'badge-oranye';
    elseif (str_contains($statusText, 'proses') || str_contains($statusText, 'persiapan') || str_contains($statusText, 'pendampingan')) $badgeClass = 'badge-kuning';
    elseif (str_contains($statusText, 'revisi') || str_contains($statusText, 'hold') || str_contains($statusText, 'dibatalkan')) $badgeClass = 'badge-merah';
    elseif (str_contains($statusText, 'selesai') || str_contains($statusText, 'stabil') || str_contains($statusText, 'go-live')) $badgeClass = 'badge-hijau';
@endphp

<!-- Toast Notification -->
<div id="toast" class="toast">
    <span id="toast-message">Berhasil disimpan!</span>
    <button type="button" onclick="document.getElementById('toast').classList.remove('show')" style="background: none; border: none; color: var(--sage, #065f46); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
</div>

<!-- Modal Konfirmasi Done Custom -->
<style>
    @keyframes fadeUpDoneModal {
        0% {
            opacity: 0;
            transform: translateY(35px) scale(0.94);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>
<div class="modal-overlay" id="modalConfirmDone" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #fff; border-radius: 12px; width: 90%; max-width: 380px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); text-align: center; animation: fadeUpDoneModal 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
        <div style="width: 52px; height: 52px; background: #d1fae5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h4 style="margin: 0 0 8px; font-size: 17px; font-weight: 700; color: #1e293b;">Konfirmasi Selesai</h4>
        <p style="margin: 0 0 24px; font-size: 13.5px; color: #64748b; line-height: 1.5;">Apakah Anda yakin ingin menandai item checklist ini sebagai <strong>Sudah Valid / Done</strong>?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" onclick="closeDoneModal()" style="flex: 1; padding: 9px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600; cursor: pointer; font-size: 13px;">Batal</button>
            <button type="button" id="btn-confirm-done" style="flex: 1; padding: 9px 16px; border-radius: 6px; border: none; background: #10b981; color: #fff; font-weight: 600; cursor: pointer; font-size: 13px; box-shadow: 0 2px 4px rgba(16,185,129,0.2);">Ya, Selesai</button>
        </div>
    </div>
</div>

<!-- Modal Kelola / Hapus Checklist -->
<div class="modal-overlay" id="modalKelolaChecklist" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #fff; border-radius: 12px; width: 90%; max-width: 550px; max-height: 85vh; display: flex; flex-direction: column; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: fadeUpDoneModal 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b;">Kelola Item Checklist Kesiapan</h4>
            <button type="button" onclick="closeKelolaModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
        </div>
        <div style="padding: 20px; overflow-y: auto; flex-grow: 1;">
            <p style="margin: 0 0 15px; font-size: 13px; color: #64748b;">
                Hapus item checklist yang tidak diperlukan oleh koperasi ini. Progres kesiapan akan otomatis dihitung ulang.
            </p>
            <div id="kelola-checklist-list" style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($implementasi->checklists as $chk)
                <div id="modal-item-{{ $chk->id }}" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <div>
                        <span style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #64748b; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; margin-right: 6px;">{{ $chk->kategori ?? 'Umum' }}</span>
                        <span style="font-size: 13px; font-weight: 600; color: #1e293b;">{{ $chk->nama_item }}</span>
                    </div>
                    <button type="button" onclick="deleteChecklist({{ $chk->id }}, '{{ addslashes($chk->nama_item) }}')" style="background: #ef4444; color: #fff; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;" title="Hapus Item Ini">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Hapus
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Tambah Item Kustom -->
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
                <h5 style="margin: 0 0 10px; font-size: 13px; font-weight: 600; color: #475569;">+ Tambah Item Checklist Kustom</h5>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="new-item-kategori" placeholder="Kategori" style="width: 110px; padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
                    <input type="text" id="new-item-nama" placeholder="Nama Item Checklist" style="flex-grow: 1; padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
                    <button type="button" onclick="addCustomChecklist({{ $implementasi->id }})" style="background: #2563eb; color: #fff; border: none; padding: 7px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 600; white-space: nowrap;">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kelola / Hapus Migrasi Data -->
<div class="modal-overlay" id="modalKelolaMigrasi" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: #fff; border-radius: 12px; width: 90%; max-width: 550px; max-height: 85vh; display: flex; flex-direction: column; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: fadeUpDoneModal 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b;">Kelola Item Migrasi Data</h4>
            <button type="button" onclick="closeKelolaMigrasiModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
        </div>
        <div style="padding: 20px; overflow-y: auto; flex-grow: 1;">
            <p style="margin: 0 0 15px; font-size: 13px; color: #64748b;">
                Hapus item migrasi data yang tidak diperlukan oleh koperasi ini.
            </p>
            <div id="kelola-migrasi-list" style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($implementasi->checklists->where('kategori', 'Migrasi') as $chk)
                <div id="modal-item-{{ $chk->id }}" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <div>
                        <span style="font-size: 13px; font-weight: 600; color: #1e293b;">{{ $chk->nama_item }}</span>
                    </div>
                    <button type="button" onclick="deleteChecklist({{ $chk->id }}, '{{ addslashes($chk->nama_item) }}')" style="background: #ef4444; color: #fff; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;" title="Hapus Item Ini">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Hapus
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Tambah Item Migrasi Kustom -->
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
                <h5 style="margin: 0 0 10px; font-size: 13px; font-weight: 600; color: #475569;">+ Tambah Item Migrasi Kustom</h5>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="new-migrasi-nama" placeholder="Nama Item Migrasi" style="flex-grow: 1; padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
                    <button type="button" onclick="addCustomMigrasi({{ $implementasi->id }})" style="background: #2563eb; color: #fff; border: none; padding: 7px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 600; white-space: nowrap;">Tambah</button>
                </div>
            </div>
        </div>
        <div style="padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeKelolaMigrasiModal()" style="padding: 7px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600; cursor: pointer; font-size: 13px;">Selesai</button>
        </div>
    </div>
</div>

<div style="max-width: 1280px; margin: 0 auto; padding: 20px 30px;">
<div class="detail-card">
    <div class="detail-header">
        <div>
            <div class="impl-number">{{ $implementasi->nomor_implementasi }}</div>
            <div style="font-size: 14px; color: #64748b; margin-top: 5px;">
                {{ $implementasi->instansi->nama_instansi ?? 'Koperasi' }} - 
                @if($implementasi->aplikasis && $implementasi->aplikasis->count() > 0)
                    {{ $implementasi->aplikasis->pluck('nama_aplikasi')->join(', ') }}
                @else
                    {{ $implementasi->aplikasi->nama_aplikasi ?? 'Aplikasi' }}
                @endif
            </div>
        </div>
        
        <div class="progress-wrapper">
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 13px; font-weight: 600;">
                <span>Progres Kesiapan</span>
                <span id="progres-text">{{ $implementasi->progres }}%</span>
            </div>
            <div class="progress-bar-bg">
                <div id="progres-fill" class="progress-bar-fill" style="width: {{ $implementasi->progres }}%;"></div>
            </div>
        </div>

        <div>
            <span class="badge {{ $badgeClass }}">{{ $implementasi->status }}</span>
        </div>
    </div>
</div>

<div class="md-layout">
    <!-- SUB-SIDEBAR (Menu Kiri) -->
    <div class="md-sidebar">
        <button class="md-tab-btn active" onclick="openTab('tab-ringkasan', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Ringkasan
        </button>
        <button class="md-tab-btn" onclick="openTab('tab-checklist', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            Checklist Kesiapan
        </button>
        <button class="md-tab-btn" onclick="openTab('tab-migrasi', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            Migrasi Data
        </button>
        <button class="md-tab-btn" onclick="openTab('tab-target-golive', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
            Go-Live
        </button>
        <button class="md-tab-btn" onclick="openTab('tab-cut-off', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Tgl Cut-Off
        </button>
        <button class="md-tab-btn" onclick="openTab('tab-aktivitas', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            Aktivitas & Log
        </button>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div style="flex-grow: 1; min-width: 0;">
        <div class="detail-card" style="margin-top: 0;">

    <!-- TAB 1: RINGKASAN -->
    <div id="tab-ringkasan" class="tab-content active">
        <div class="summary-grid">
            <div class="summary-item" style="position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div class="summary-label">Go-Live</div>
                    <div style="position: relative;">
                        <button onclick="document.getElementById('golive-dropdown').style.display = document.getElementById('golive-dropdown').style.display === 'none' ? 'block' : 'none';" style="background: none; border: none; cursor: pointer; color: #64748b; padding: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.5"></circle><circle cx="19" cy="12" r="1.5"></circle><circle cx="5" cy="12" r="1.5"></circle></svg>
                        </button>
                        <div id="golive-dropdown" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e2e8f0; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); z-index: 10; min-width: 120px;">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('golive-dropdown').style.display = 'none'; openTab('tab-target-golive', document.querySelector('[onclick*=\'tab-target-golive\']'))" style="display: block; padding: 10px 14px; color: #475569; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    Edit
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="summary-value">{{ $implementasi->target_go_live ? $implementasi->target_go_live->format('d M Y') : 'Belum Ditentukan' }}</div>
            </div>
            <div class="summary-item" style="position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div class="summary-label">Tgl Cut-Off</div>
                    <div style="position: relative;">
                        <button onclick="document.getElementById('cutoff-dropdown').style.display = document.getElementById('cutoff-dropdown').style.display === 'none' ? 'block' : 'none';" style="background: none; border: none; cursor: pointer; color: #64748b; padding: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.5"></circle><circle cx="19" cy="12" r="1.5"></circle><circle cx="5" cy="12" r="1.5"></circle></svg>
                        </button>
                        <div id="cutoff-dropdown" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e2e8f0; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); z-index: 10; min-width: 120px;">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('cutoff-dropdown').style.display = 'none'; openTab('tab-cut-off', document.querySelector('[onclick*=\'tab-cut-off\']'))" style="display: block; padding: 10px 14px; color: #475569; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    Edit
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="summary-value">{{ $implementasi->tanggal_cut_off ? $implementasi->tanggal_cut_off->format('d M Y') : 'Belum Ditentukan' }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Tgl Pelatihan</div>
                <div class="summary-value">
                    @if($implementasi->tanggal_pelatihan)
                        {{ $implementasi->tanggal_pelatihan->format('d M Y') }}
                        @if($implementasi->tanggal_selesai && $implementasi->tanggal_selesai->format('Y-m-d') !== $implementasi->tanggal_pelatihan->format('Y-m-d'))
                            - {{ $implementasi->tanggal_selesai->format('d M Y') }}
                        @endif
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Berita Acara</div>
                <div class="summary-value">
                    @if($implementasi->berita_acara)
                        <a href="{{ Storage::url($implementasi->berita_acara) }}" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 500;">Lihat PDF</a>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Anggota Yang Hadir</div>
                <div class="summary-value">{{ $implementasi->anggota_hadir ?? '-' }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Kontak PIC Koperasi</div>
                <div class="summary-value">
                    <span style="font-weight:400; font-size:12px;">WA: {{ $implementasi->kontak_pic }}<br>Email: {{ $implementasi->email_pic ?? '-' }}</span>
                </div>
            </div>
            <div class="summary-item" style="border-left: 3px solid #f59e0b;">
                <div class="summary-label" style="color: #d97706;">Tindakan Berikutnya (Next Action)</div>
                <div class="summary-value">{{ $implementasi->tindakan_berikutnya ?? 'Belum ada' }}</div>
                <div style="font-size: 12px; margin-top: 5px;">PIC: {{ $implementasi->pic_tindakan ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- TAB 2: CHECKLIST -->
    <div id="tab-checklist" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #475569;">Checklist Kesiapan Implementasi</h4>
            @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                <button type="button" onclick="openKelolaModal()" style="background: #475569; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;" title="Hapus atau Tambah Item Checklist">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    Edit
                </button>
            @endif
        </div>
        @php
            $nonMigrasiChecklists = $implementasi->checklists->where('kategori', '!=', 'Migrasi');
        @endphp
        @if($nonMigrasiChecklists->count() > 0)
            <div style="overflow-x: auto;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Item Kesiapan</th>
                            <th style="width: 200px;">Status</th>
                            <th>Catatan Tambahan</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nonMigrasiChecklists as $chk)
                        <tr id="chk-row-{{ $chk->id }}">
                            <td>{{ $chk->kategori ?? '-' }}</td>
                            <td style="font-weight: 500;">{{ $chk->nama_item }}</td>
                            <td>
                                @if(Auth::user()->role === \App\Enums\UserRole::PELAPOR)
                                    <span style="font-weight:600; color: #475569;">{{ $chk->status }}</span>
                                @else
                                    <select id="status-{{ $chk->id }}" class="checklist-select">
                                        <option value="Belum Dikirim" {{ $chk->status == 'Belum Dikirim' ? 'selected' : '' }}>Belum Dikirim</option>
                                        <option value="Sudah Dikirim" {{ $chk->status == 'Sudah Dikirim' ? 'selected' : '' }}>Sudah Dikirim</option>
                                        <option value="Sedang Diproses" {{ $chk->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="Perlu Revisi" {{ $chk->status == 'Perlu Revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                                        <option value="Sudah Valid" {{ ($chk->status == 'Sudah Valid' || $chk->status == 'Done') ? 'selected' : '' }}>Sudah Valid (Done)</option>
                                    </select>
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->role === \App\Enums\UserRole::PELAPOR)
                                    <span style="color: #64748b; font-style: italic;">{{ $chk->catatan ?? '-' }}</span>
                                @else
                                    <input type="text" id="catatan-{{ $chk->id }}" class="checklist-input" value="{{ $chk->catatan }}" placeholder="Tambahkan catatan...">
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                                    <div style="display: flex; gap: 6px; align-items: center; justify-content: center;">
                                        <button type="button" onclick="updateChecklist({{ $chk->id }})" style="background: #2563eb; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500;">Simpan</button>
                                        <button type="button" onclick="markAsDone({{ $chk->id }})" style="background: #10b981; color: #fff; border: none; padding: 6px 9px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;" title="Tandai Selesai & Naikkan Progres">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </button>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #64748b;">
                Belum ada data checklist kesiapan.
            </div>
        @endif
    </div>

    <!-- TAB 3: MIGRASI DATA -->
    <div id="tab-migrasi" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #475569;">Item Migrasi Data Koperasi</h4>
            @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                <button type="button" onclick="openKelolaMigrasiModal()" style="background: #475569; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;" title="Hapus atau Tambah Item Migrasi">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    Edit
                </button>
            @endif
        </div>
        @php
            $migrasiChecklists = $implementasi->checklists->where('kategori', 'Migrasi');
        @endphp
        @if($migrasiChecklists->count() > 0)
            <div style="overflow-x: auto;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th>Item Migrasi Data</th>
                            <th style="width: 200px;">Status</th>
                            <th>Catatan Tambahan</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($migrasiChecklists as $chk)
                        <tr id="chk-row-{{ $chk->id }}">
                            <td style="font-weight: 500;">{{ $chk->nama_item }}</td>
                            <td>
                                @if(Auth::user()->role === \App\Enums\UserRole::PELAPOR)
                                    <span style="font-weight:600; color: #475569;">{{ $chk->status }}</span>
                                @else
                                    <select id="status-{{ $chk->id }}" class="checklist-select">
                                        <option value="Belum Dikirim" {{ $chk->status == 'Belum Dikirim' ? 'selected' : '' }}>Belum Dikirim</option>
                                        <option value="Sudah Dikirim" {{ $chk->status == 'Sudah Dikirim' ? 'selected' : '' }}>Sudah Dikirim</option>
                                        <option value="Sedang Diproses" {{ $chk->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="Perlu Revisi" {{ $chk->status == 'Perlu Revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                                        <option value="Sudah Valid" {{ ($chk->status == 'Sudah Valid' || $chk->status == 'Done') ? 'selected' : '' }}>Sudah Valid (Done)</option>
                                    </select>
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->role === \App\Enums\UserRole::PELAPOR)
                                    <span style="color: #64748b; font-style: italic;">{{ $chk->catatan ?? '-' }}</span>
                                @else
                                    <input type="text" id="catatan-{{ $chk->id }}" class="checklist-input" value="{{ $chk->catatan }}" placeholder="Tambahkan catatan...">
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                                    <div style="display: flex; gap: 6px; align-items: center; justify-content: center;">
                                        <button type="button" onclick="updateChecklist({{ $chk->id }})" style="background: #2563eb; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500;">Simpan</button>
                                        <button type="button" onclick="markAsDone({{ $chk->id }})" style="background: #10b981; color: #fff; border: none; padding: 6px 9px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;" title="Tandai Selesai">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </button>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #64748b;">
                Belum ada data migrasi.
            </div>
        @endif
    </div>

    <!-- TAB 4: GO-LIVE -->
    <div id="tab-target-golive" class="tab-content">
        <form action="{{ route('implementasi.golive.update', $implementasi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #475569;">Detail Go-Live</h4>
                <button type="submit" style="background-color: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer;">Simpan Perubahan</button>
            </div>
            
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                <!-- Auto-filled Fields -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Aplikasi / Modul</label>
                        <input type="text" class="form-control" value="{{ $implementasi->aplikasis && $implementasi->aplikasis->count() > 0 ? $implementasi->aplikasis->pluck('nama_aplikasi')->join(', ') : ($implementasi->aplikasi->nama_aplikasi ?? '-') }}" readonly style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: #e2e8f0; color: #64748b; cursor: not-allowed;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">PIC PT SAKTI</label>
                        <input type="text" class="form-control" value="{{ $implementasi->nama_trainer ?? '-' }}" readonly style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: #e2e8f0; color: #64748b; cursor: not-allowed;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">PIC Koperasi</label>
                        <input type="text" class="form-control" value="{{ $implementasi->anggota_hadir ?? '-' }}" readonly style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: #e2e8f0; color: #64748b; cursor: not-allowed;">
                    </div>
                </div>

                <!-- Scheduling & Location -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Metode Pendampingan</label>
                        <select name="metode_pendampingan" class="form-control" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: white;">
                            <option value="">Pilih Metode</option>
                            <option value="Online (Zoom/Meet)" {{ $implementasi->metode_pendampingan == 'Online (Zoom/Meet)' ? 'selected' : '' }}>Online (Zoom/Meet)</option>
                            <option value="Offline (Kunjungan)" {{ $implementasi->metode_pendampingan == 'Offline (Kunjungan)' ? 'selected' : '' }}>Offline (Kunjungan)</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Link Meeting</label>
                        <input type="text" name="link_meeting" class="form-control" value="{{ $implementasi->link_meeting }}" placeholder="Masukkan link meeting jika online" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Tanggal</label>
                        <input type="date" name="target_go_live" class="form-control" value="{{ $implementasi->target_go_live ? $implementasi->target_go_live->format('Y-m-d') : '' }}" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Waktu</label>
                        <input type="time" name="waktu_go_live" class="form-control" value="{{ $implementasi->waktu_go_live ? \Carbon\Carbon::parse($implementasi->waktu_go_live)->format('H:i') : '' }}" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Tempat</label>
                        <select name="tempat_go_live" class="form-control" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: white;">
                            <option value="">Pilih Tempat</option>
                            <option value="Zoom" {{ $implementasi->tempat_go_live == 'Zoom' ? 'selected' : '' }}>Zoom</option>
                            <option value="Gmeet" {{ $implementasi->tempat_go_live == 'Gmeet' ? 'selected' : '' }}>Gmeet</option>
                            <option value="Lokasi" {{ $implementasi->tempat_go_live == 'Lokasi' ? 'selected' : '' }}>Lokasi</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Status</label>
                        <select name="status_go_live" class="form-control" style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; background: white;">
                            <option value="Belum Siap Go Live" {{ $implementasi->status_go_live == 'Belum Siap Go Live' ? 'selected' : '' }}>Belum Siap Go Live</option>
                            <option value="Siap Go Live" {{ $implementasi->status_go_live == 'Siap Go Live' ? 'selected' : '' }}>Siap Go Live</option>
                        </select>
                    </div>
                </div>

                <!-- Textareas -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Catatan Kesiapan</label>
                    <textarea name="catatan_kesiapan" class="form-control" rows="3" placeholder="Tuliskan catatan kesiapan..." style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; resize: vertical;">{{ $implementasi->catatan_kesiapan }}</textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Potensi Risiko</label>
                    <textarea name="potensi_risiko" class="form-control" rows="3" placeholder="Tuliskan potensi risiko..." style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; resize: vertical;">{{ $implementasi->potensi_risiko }}</textarea>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 5px;">Rencana Mitigasi</label>
                    <textarea name="rencana_mitigasi" class="form-control" rows="3" placeholder="Tuliskan rencana mitigasi..." style="width: 100%; border: 1px solid #cbd5e1; padding: 8px; border-radius: 4px; resize: vertical;">{{ $implementasi->rencana_mitigasi }}</textarea>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 5: TGL CUT-OFF -->
    <div id="tab-cut-off" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #475569;">Tanggal Cut-Off</h4>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; text-align: center;">
            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Tanggal Cut-Off</div>
            <div style="font-size: 24px; font-weight: 700; color: #0284c7;">
                {{ $implementasi->tanggal_cut_off ? $implementasi->tanggal_cut_off->format('d M Y') : '-' }}
            </div>
        </div>
    </div>

    <!-- TAB 6: AKTIVITAS & LOG -->
    <div id="tab-aktivitas" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: #475569;">Riwayat Aktivitas & Log</h4>
        </div>
        <div class="timeline">
            @forelse($implementasi->logs as $log)
                @php
                    $logTime = '-';
                    if ($log->created_at) {
                        $logTime = is_string($log->created_at) ? \Carbon\Carbon::parse($log->created_at)->format('d M Y - H:i') : $log->created_at->format('d M Y - H:i');
                    }
                @endphp
                <div class="timeline-item">
                    <div class="timeline-time">{{ $logTime }} | <strong>{{ $log->user->nama ?? 'Sistem' }}</strong></div>
                    <div class="timeline-content">
                        <div style="font-weight: 600; margin-bottom: 5px;">{{ $log->aktivitas }}</div>
                        @if($log->catatan && !str_contains(strtolower($log->catatan), 'ajax'))
                            <div style="font-size: 12px; color: #475569; margin-top: 4px;">{{ $log->catatan }}</div>
                        @endif
                        @if($log->data_sebelum && $log->data_sesudah)
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                <strong>Status:</strong> <span style="text-decoration: line-through;">{{ is_array($log->data_sebelum) ? ($log->data_sebelum['status'] ?? '') : '' }}</span> &rarr; <span style="color:#2563eb;">{{ is_array($log->data_sesudah) ? ($log->data_sesudah['status'] ?? '') : '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 10px;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    <div style="font-weight: 600; font-size: 14px; color: #475569; margin-bottom: 4px;">Belum Ada Aktivitas</div>
                    <div style="font-size: 13px; color: #64748b;">Setiap perubahan status checklist atau update implementasi akan otomatis tercatat di sini.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    // Tab Navigation Logic
    function openTab(tabId, btn) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        // Remove active class from buttons
        document.querySelectorAll('.md-tab-btn').forEach(el => el.classList.remove('active'));
        
        // Show target content
        document.getElementById(tabId).classList.add('active');
        // Set active button
        if (btn) {
            btn.classList.add('active');
        } else if (event && event.currentTarget) {
            event.currentTarget.classList.add('active');
        }
    }

    // Quick Mark as Done Modal
    let selectedChecklistId = null;

    function markAsDone(id) {
        selectedChecklistId = id;
        document.getElementById('modalConfirmDone').style.display = 'flex';
    }

    function closeDoneModal() {
        selectedChecklistId = null;
        document.getElementById('modalConfirmDone').style.display = 'none';
    }

    document.getElementById('btn-confirm-done').addEventListener('click', function() {
        if (selectedChecklistId) {
            const select = document.getElementById('status-' + selectedChecklistId);
            if (select) {
                select.value = 'Sudah Valid';
            }
            updateChecklist(selectedChecklistId);
            closeDoneModal();
        }
    });

    // Kelola Checklist Modal
    function openKelolaModal() {
        document.getElementById('modalKelolaChecklist').style.display = 'flex';
    }

    function closeKelolaModal() {
        document.getElementById('modalKelolaChecklist').style.display = 'none';
    }

    function openKelolaMigrasiModal() {
        document.getElementById('modalKelolaMigrasi').style.display = 'flex';
    }

    function closeKelolaMigrasiModal() {
        document.getElementById('modalKelolaMigrasi').style.display = 'none';
    }

    function deleteChecklist(id, name) {
        if (!confirm(`Apakah Anda yakin ingin menghapus item "${name}" dari checklist ini?`)) {
            return;
        }

        fetch(`{{ url('implementasi/checklist') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const modalItem = document.getElementById('modal-item-' + id);
                if (modalItem) modalItem.remove();

                const tableRow = document.getElementById('chk-row-' + id);
                if (tableRow) tableRow.remove();

                document.getElementById('progres-text').innerText = data.new_progres + '%';
                document.getElementById('progres-fill').style.width = data.new_progres + '%';

                showToast('Item checklist berhasil dihapus!');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menghapus item checklist.');
        });
    }

    function addCustomChecklist(implId) {
        const namaInput = document.getElementById('new-item-nama');
        const kategoriInput = document.getElementById('new-item-kategori');
        const nama = namaInput.value.trim();
        const kategori = kategoriInput.value.trim() || 'Lainnya';

        if (!nama) {
            alert('Nama item checklist tidak boleh kosong.');
            return;
        }

        fetch(`{{ url('implementasi') }}/${implId}/checklist`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama_item: nama, kategori: kategori })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                namaInput.value = '';
                kategoriInput.value = '';

                document.getElementById('progres-text').innerText = data.new_progres + '%';
                document.getElementById('progres-fill').style.width = data.new_progres + '%';

                showToast('Item checklist baru berhasil ditambahkan! Silakan refresh untuk memuat ulang tabel.');
                setTimeout(() => location.reload(), 1200);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menambahkan item checklist.');
        });
    }

    function addCustomMigrasi(implId) {
        const namaInput = document.getElementById('new-migrasi-nama');
        const nama = namaInput.value.trim();

        if (!nama) {
            alert('Nama item migrasi tidak boleh kosong.');
            return;
        }

        fetch(`{{ url('implementasi') }}/${implId}/checklist`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama_item: nama, kategori: 'Migrasi' })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                namaInput.value = '';
                showToast('Item migrasi baru berhasil ditambahkan!');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menambahkan item migrasi.');
        });
    }

    // AJAX Update Checklist
    function updateChecklist(id) {
        const status = document.getElementById('status-' + id).value;
        const catatan = document.getElementById('catatan-' + id).value;
        
        fetch(`{{ url('implementasi/checklist') }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status, catatan: catatan })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update Progress UI dynamically
                document.getElementById('progres-text').innerText = data.new_progres + '%';
                document.getElementById('progres-fill').style.width = data.new_progres + '%';
                
                // Show Toast Notification
                showToast('Checklist berhasil di-update!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    }

    // Toast Notification Logic
    function showToast(message) {
        const toast = document.getElementById('toast');
        document.getElementById('toast-message').innerText = message;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
</script>
@endsection
