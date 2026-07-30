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

    /* Tabs UI */
    .tabs-nav {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 20px;
        overflow-x: auto;
    }
    .tab-btn {
        padding: 12px 20px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }
    .tab-btn:hover {
        color: #0f172a;
    }
    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }
    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    .tab-content.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Grid Ringkasan */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
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
        <div style="padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeKelolaModal()" style="padding: 7px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600; cursor: pointer; font-size: 13px;">Selesai</button>
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

<div class="detail-card">
    <!-- Tab Navigation -->
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="openTab('tab-ringkasan')">Ringkasan</button>
        <button class="tab-btn" onclick="openTab('tab-checklist')">Checklist Kesiapan</button>
        <button class="tab-btn" onclick="openTab('tab-aktivitas')">Aktivitas & Log</button>
    </div>

    <!-- TAB 1: RINGKASAN -->
    <div id="tab-ringkasan" class="tab-content active">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Target Go-Live</div>
                <div class="summary-value">{{ $implementasi->target_go_live ? $implementasi->target_go_live->format('d M Y') : 'Belum Ditentukan' }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Tgl Cut-Off</div>
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
        @if($implementasi->checklists->count() > 0)
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
                        @foreach($implementasi->checklists as $chk)
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
                Belum ada data checklist. (Tim dapat men-generate template checklist di sini).
            </div>
        @endif
    </div>

    <!-- TAB 3: AKTIVITAS & LOG -->
    <div id="tab-aktivitas" class="tab-content">
        <div class="timeline">
            @forelse($implementasi->logs as $log)
                <div class="timeline-item">
                    <div class="timeline-time">{{ $log->created_at->format('d M Y - H:i') }} | <strong>{{ $log->user->nama ?? 'Sistem' }}</strong></div>
                    <div class="timeline-content">
                        <div style="font-weight: 600; margin-bottom: 5px;">{{ $log->aktivitas }}</div>
                        @if($log->data_sebelum && $log->data_sesudah)
                            <div style="font-size: 12px; color: #64748b;">
                                <strong>Status:</strong> <span style="text-decoration: line-through;">{{ $log->data_sebelum['status'] ?? '' }}</span> &rarr; <span style="color:#2563eb;">{{ $log->data_sesudah['status'] ?? '' }}</span>
                            </div>
                        @endif

                    </div>
                </div>
            @empty
                <div style="color: #64748b;">Belum ada aktivitas tercatat.</div>
            @endforelse
        </div>
    </div>
</div>
</div>

<script>
    // Tab Navigation Logic
    function openTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        // Remove active class from buttons
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        
        // Show target content
        document.getElementById(tabId).classList.add('active');
        // Set active button
        event.currentTarget.classList.add('active');
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
