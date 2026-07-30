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
                <div class="summary-value">{{ $implementasi->tanggal_pelatihan ? $implementasi->tanggal_pelatihan->format('d M Y') : '-' }}</div>
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
        @if($implementasi->checklists->count() > 0)
            <div style="overflow-x: auto;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Item Kesiapan</th>
                            <th style="width: 200px;">Status</th>
                            <th>Catatan Tambahan</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($implementasi->checklists as $chk)
                        <tr>
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
                                        <option value="Sudah Valid" {{ $chk->status == 'Sudah Valid' ? 'selected' : '' }}>Sudah Valid</option>
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
                            <td>
                                @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                                    <button onclick="updateChecklist({{ $chk->id }})" style="background: #2563eb; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">Simpan</button>
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
                        @if($log->catatan)
                            <div style="font-size: 12px; margin-top: 5px; font-style: italic;">"{{ $log->catatan }}"</div>
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
