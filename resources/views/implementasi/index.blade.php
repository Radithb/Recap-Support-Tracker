@extends('layouts.app')

@section('page_title', 'Monitoring Koperasi')
@section('page_subtitle', 'Dashboard Monitoring')

@section('content')
<style>
    /* Vanilla CSS styling for dashboard */
    .dashboard-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .implementasi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .implementasi-table th, .implementasi-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .implementasi-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }
    
    /* Dynamic Status Labels */
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    
    .badge-abu { background-color: #e2e8f0; color: #475569; }
    .badge-biru { background-color: #dbeafe; color: #1d4ed8; }
    .badge-kuning { background-color: #fef08a; color: #854d0e; }
    .badge-oranye { background-color: #ffedd5; color: #c2410c; }
    .badge-merah { background-color: #fee2e2; color: #b91c1c; }
    .badge-hijau { background-color: #dcfce3; color: #166534; }
    
    /* Progress Bar */
    .progress-container {
        width: 100%;
        background-color: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        height: 8px;
        margin-top: 5px;
    }
    
    .progress-bar {
        height: 100%;
        background-color: #10b981;
        transition: width 0.3s ease;
    }
    
    .btn-action {
        padding: 8px 16px;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: background-color 0.2s, transform 0.1s;
    }
    
    .btn-action:hover {
        background-color: #1d4ed8;
    }
    
    .btn-action:active {
        transform: scale(0.97);
    }
    
    .dark-mode .dashboard-card {
        background: #1e293b;
        color: #f8fafc;
        box-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    .dark-mode .implementasi-table th {
        background-color: #0f172a;
        color: #e2e8f0;
        border-bottom-color: #334155;
    }
    
    .dark-mode .implementasi-table td {
        border-bottom-color: #334155;
    }
    
    .dark-mode .badge-abu { background-color: #334155; color: #cbd5e1; }
    .dark-mode .badge-biru { background-color: #1e3a8a; color: #bfdbfe; }
    .dark-mode .badge-kuning { background-color: #713f12; color: #fef08a; }
    .dark-mode .badge-oranye { background-color: #7c2d12; color: #ffedd5; }
    .dark-mode .badge-merah { background-color: #7f1d1d; color: #fecaca; }
    .dark-mode .badge-hijau { background-color: #14532d; color: #bbf7d0; }
    .dropdown-kebab {
        position: relative;
        display: inline-block;
    }
    .btn-kebab {
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #64748b;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .btn-kebab:hover { background: #f1f5f9; }
    .kebab-menu-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 50;
        min-width: 120px;
        overflow: hidden;
    }
    .kebab-menu-content.show { display: block; }
    .kebab-item {
        display: block;
        width: 100%;
        text-align: left;
        padding: 10px 15px;
        color: #1e293b;
        text-decoration: none;
        font-size: 13px;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .kebab-item:hover { background: #f1f5f9; }
    .kebab-item.text-red { color: #ef4444; }
    .kebab-item.text-red:hover { background: #fef2f2; }
    
    .dark-mode .progress-container { background-color: #334155; }
</style>

<div style="max-width: 1280px; margin: 0 auto; padding: 20px 30px;">
    <div class="dashboard-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0;">Monitoring Running Koperasi ({{ $implementasis->count() }})</h2>
        @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
            <button class="btn-action" style="background-color: #10b981;" onclick="openModal('modalDataBaru')">+ Data Baru</button>
        @endif
    </div>

    @if(session('success'))
        <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
        </div>
    @endif


    <div class="table-responsive">
        <table class="implementasi-table">
            <thead>
                <tr>
                    <th>No. Impl</th>
                    <th>Koperasi</th>
                    <th>Aplikasi</th>
                    <th>Anggota Yang Hadir</th>
                    <th>Target Go-Live</th>
                    <th>Progres</th>
                    <th>Status</th>
                    <th>Next Action</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($implementasis as $impl)
                    @php
                        $statusText = strtolower($impl->status);
                        $badgeClass = 'badge-abu';
                        
                        if (str_contains($statusText, 'dijadwalkan')) {
                            $badgeClass = 'badge-biru';
                        } elseif (str_contains($statusText, 'menunggu')) {
                            $badgeClass = 'badge-oranye';
                        } elseif (str_contains($statusText, 'proses') || str_contains($statusText, 'persiapan') || str_contains($statusText, 'pendampingan')) {
                            $badgeClass = 'badge-kuning';
                        } elseif (str_contains($statusText, 'revisi') || str_contains($statusText, 'hold') || str_contains($statusText, 'dibatalkan') || str_contains($statusText, 'masalah')) {
                            $badgeClass = 'badge-merah';
                        } elseif (str_contains($statusText, 'selesai') || str_contains($statusText, 'stabil') || str_contains($statusText, 'siap go-live') || str_contains($statusText, 'go-live')) {
                            $badgeClass = 'badge-hijau';
                        }
                    @endphp
                    <tr>
                        <td><strong>{{ $impl->nomor_implementasi }}</strong></td>
                        <td>{{ $impl->instansi->nama_instansi ?? '-' }}</td>
                        <td>
                            @if($impl->aplikasis && $impl->aplikasis->count() > 0)
                                {{ $impl->aplikasis->pluck('nama_aplikasi')->join(', ') }}
                            @else
                                {{ $impl->aplikasi->nama_aplikasi ?? '-' }}
                            @endif
                        </td>
                        <td>{{ $impl->anggota_hadir ?? '-' }}</td>
                        <td>{{ $impl->target_go_live ? $impl->target_go_live->format('d M Y') : '-' }}</td>
                        <td style="min-width: 120px;">
                            <div style="font-weight: 600;">{{ $impl->progres }}%</div>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: {{ $impl->progres }}%;"></div>
                            </div>
                        </td>
                        <td><span class="badge {{ $badgeClass }}">{{ $impl->status }}</span></td>
                        <td>
                            @if($impl->tindakan_berikutnya)
                                <div style="font-size: 13px; font-weight: 500;">{{ $impl->tindakan_berikutnya }}</div>
                                <div style="font-size: 11px; opacity: 0.7;">PIC: {{ $impl->pic_tindakan ?? '-' }}</div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="{{ route('implementasi.show', $impl->id) }}" class="btn-action">Detail</a>
                                
                                @if(Auth::user()->role !== \App\Enums\UserRole::PELAPOR)
                                <div class="dropdown-kebab">
                                    <button type="button" class="btn-kebab" onclick="toggleKebab({{ $impl->id }}, event)">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                    </button>
                                    <div id="kebab-menu-{{ $impl->id }}" class="kebab-menu-content">
                                        <button type="button" class="kebab-item" onclick="openEditModal({{ $impl->id }})">Edit</button>
                                        <form action="{{ route('implementasi.destroy', $impl->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data implementasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kebab-item text-red">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 30px; color: #64748b;">Belum ada data implementasi koperasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</div>

<!-- Modal Data Baru -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .modal-overlay.active { display: flex; }
    .modal-container {
        background: #fff;
        width: 100%;
        max-width: 600px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .dark-mode .modal-container {
        background: #1e293b;
        color: #f8fafc;
    }
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dark-mode .modal-header { border-color: #334155; }
    .modal-body {
        padding: 20px;
        max-height: 70vh;
        overflow-y: auto;
    }
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .dark-mode .modal-footer { border-color: #334155; }
    
    .form-group { margin-bottom: 15px; }
    .form-label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
    }
    .dark-mode .form-control {
        background: #0f172a;
        border-color: #334155;
        color: #f8fafc;
    }
    .btn-close-modal { background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b; }
    .btn-secondary { background: #e2e8f0; color: #475569; padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-weight: 500;}
    .dark-mode .btn-secondary { background: #334155; color: #cbd5e1; }
    .btn-primary { background: #2563eb; color: #fff; padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-weight: 500;}
    
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
</style>

<div class="modal-overlay" id="modalDataBaru">
    <div class="modal-container">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 16px;">Tambah Data Implementasi</h3>
            <button class="btn-close-modal" onclick="closeModal('modalDataBaru')">&times;</button>
        </div>
        <form action="{{ route('implementasi.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Koperasi</label>
                    <select name="instansi_id" class="form-control" required>
                        <option value="">Pilih Koperasi</option>
                        @foreach($instansis as $instansi)
                            <option value="{{ $instansi->instansi_id }}">{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Aplikasi/Modul</label>
                    <div id="aplikasi-container">
                        <div class="aplikasi-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <select name="aplikasi_id[]" class="form-control" required style="flex-grow: 1;">
                                <option value="" disabled selected>Pilih Aplikasi</option>
                                @foreach($aplikasis as $app)
                                    <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addAplikasiInput()">+</button>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pelatihan</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Pelatihan</label>
                        <select name="metode_pelatihan" class="form-control" required>
                            <option value="Online (Zoom/Meet)">Online (Zoom/Meet)</option>
                            <option value="Offline (Kunjungan)">Offline (Kunjungan)</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Anggota Yang Hadir</label>
                        <div id="anggota-container">
                            <div class="anggota-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="anggota_hadir[]" class="form-control" placeholder="Nama Anggota" required>
                                <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addAnggotaInput()">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Trainer</label>
                        <div id="trainer-container">
                            <div class="trainer-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="nama_trainer[]" class="form-control">
                                <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addTrainerInput()">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Email PIC</label>
                        <input type="email" name="email_pic" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp PIC</label>
                        <input type="text" name="kontak_pic" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Pelatihan</label>
                    <textarea name="catatan_pelatihan" class="form-control" rows="2" placeholder="Hasil pelatihan..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalDataBaru')">Batal</button>
                <button type="submit" class="btn-primary">Simpan & Buat Checklist</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Data -->
<style>
    .skeleton-box {
        background: #e2e8f0;
        border-radius: 4px;
        position: relative;
        overflow: hidden;
    }
    .skeleton-box::after {
        content: "";
        position: absolute;
        top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: loading 1.5s infinite;
    }
    @keyframes loading {
        100% { left: 100%; }
    }
    .dark-mode .skeleton-box { background: #334155; }
    .dark-mode .skeleton-box::after { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent); }
</style>
<div class="modal-overlay" id="modalEditData">
    <div class="modal-container">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 16px;">Edit Data Implementasi</h3>
            <button class="btn-close-modal" onclick="closeModal('modalEditData')">&times;</button>
        </div>
        <div id="edit-modal-content">
            <!-- Form will be loaded here via AJAX -->
            <div style="padding: 20px;">
                <div class="skeleton-box" style="width: 30%; height: 14px; margin-bottom: 8px;"></div>
                <div class="skeleton-box" style="width: 100%; height: 38px; margin-bottom: 20px; border-radius: 6px;"></div>
                
                <div class="skeleton-box" style="width: 30%; height: 14px; margin-bottom: 8px;"></div>
                <div class="skeleton-box" style="width: 100%; height: 38px; margin-bottom: 20px; border-radius: 6px;"></div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div class="skeleton-box" style="width: 50%; height: 14px; margin-bottom: 8px;"></div>
                        <div class="skeleton-box" style="width: 100%; height: 38px; border-radius: 6px;"></div>
                    </div>
                    <div>
                        <div class="skeleton-box" style="width: 50%; height: 14px; margin-bottom: 8px;"></div>
                        <div class="skeleton-box" style="width: 100%; height: 38px; border-radius: 6px;"></div>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                    <div class="skeleton-box" style="width: 80px; height: 38px; border-radius: 4px;"></div>
                    <div class="skeleton-box" style="width: 140px; height: 38px; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function addAnggotaInput() {
        const container = document.getElementById('anggota-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'anggota-input-group';
        inputGroup.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
        
        inputGroup.innerHTML = `
            <input type="text" name="anggota_hadir[]" class="form-control" placeholder="Nama Anggota" required>
            <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="removeAnggotaInput(this)">-</button>
        `;
        container.appendChild(inputGroup);
    }

    function removeAnggotaInput(btn) {
        btn.parentElement.remove();
    }

    function addTrainerInput() {
        const container = document.getElementById('trainer-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'trainer-input-group';
        inputGroup.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
        
        inputGroup.innerHTML = `
            <input type="text" name="nama_trainer[]" class="form-control">
            <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="removeTrainerInput(this)">-</button>
        `;
        container.appendChild(inputGroup);
    }

    function removeTrainerInput(btn) {
        btn.parentElement.remove();
    }

    function addAplikasiInput() {
        const container = document.getElementById('aplikasi-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'aplikasi-input-group';
        inputGroup.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
        
        inputGroup.innerHTML = `
            <select name="aplikasi_id[]" class="form-control" required style="flex-grow: 1;">
                <option value="" disabled selected>Pilih Aplikasi</option>
                @foreach($aplikasis as $app)
                    <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                @endforeach
            </select>
            <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="removeAplikasiInput(this)">-</button>
        `;
        container.appendChild(inputGroup);
    }

    function removeAplikasiInput(btn) {
        btn.parentElement.remove();
    }
    // Kebab Menu Logic
    function toggleKebab(id, event) {
        event.stopPropagation();
        // Close all other kebabs
        document.querySelectorAll('.kebab-menu-content').forEach(menu => {
            if (menu.id !== 'kebab-menu-' + id) {
                menu.classList.remove('show');
            }
        });
        // Toggle current kebab
        document.getElementById('kebab-menu-' + id).classList.toggle('show');
    }

    // Close kebab menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown-kebab')) {
            document.querySelectorAll('.kebab-menu-content').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Edit Modal Logic
    function openEditModal(id) {
        // Tutup kebab menu yang sedang terbuka
        document.querySelectorAll('.kebab-menu-content').forEach(menu => {
            menu.classList.remove('show');
        });
        
        openModal('modalEditData');
        const container = document.getElementById('edit-modal-content');
        container.innerHTML = `
            <div style="padding: 20px;">
                <div class="skeleton-box" style="width: 30%; height: 14px; margin-bottom: 8px;"></div>
                <div class="skeleton-box" style="width: 100%; height: 38px; margin-bottom: 20px; border-radius: 6px;"></div>
                
                <div class="skeleton-box" style="width: 30%; height: 14px; margin-bottom: 8px;"></div>
                <div class="skeleton-box" style="width: 100%; height: 38px; margin-bottom: 20px; border-radius: 6px;"></div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div class="skeleton-box" style="width: 50%; height: 14px; margin-bottom: 8px;"></div>
                        <div class="skeleton-box" style="width: 100%; height: 38px; border-radius: 6px;"></div>
                    </div>
                    <div>
                        <div class="skeleton-box" style="width: 50%; height: 14px; margin-bottom: 8px;"></div>
                        <div class="skeleton-box" style="width: 100%; height: 38px; border-radius: 6px;"></div>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                    <div class="skeleton-box" style="width: 80px; height: 38px; border-radius: 4px;"></div>
                    <div class="skeleton-box" style="width: 140px; height: 38px; border-radius: 4px;"></div>
                </div>
            </div>`;
        
        fetch(`/implementasi/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Terjadi kesalahan saat memuat form.');
            return response.text();
        })
        .then(html => {
            container.innerHTML = html;
        })
        .catch(error => {
            container.innerHTML = `<div style="padding: 30px; text-align: center; color: #ef4444;">${error.message}</div>`;
        });
    }

    // Dynamic inputs untuk form edit
    function addEditAplikasiInput() {
        const container = document.getElementById('edit-aplikasi-container');
        const originalGroup = container.querySelector('.aplikasi-input-group');
        const newGroup = originalGroup.cloneNode(true);
        newGroup.querySelector('select').selectedIndex = 0;
        
        const btn = newGroup.querySelector('button');
        btn.textContent = '-';
        btn.style.backgroundColor = '#ef4444';
        btn.onclick = function() { removeEditInput(this); };
        
        container.appendChild(newGroup);
    }
    
    function addEditAnggotaInput() {
        const container = document.getElementById('edit-anggota-container');
        const originalGroup = container.querySelector('.anggota-input-group');
        const newGroup = originalGroup.cloneNode(true);
        newGroup.querySelector('input').value = '';
        
        const btn = newGroup.querySelector('button');
        btn.textContent = '-';
        btn.style.backgroundColor = '#ef4444';
        btn.onclick = function() { removeEditInput(this); };
        
        container.appendChild(newGroup);
    }
    
    function addEditTrainerInput() {
        const container = document.getElementById('edit-trainer-container');
        const originalGroup = container.querySelector('.trainer-input-group');
        const newGroup = originalGroup.cloneNode(true);
        newGroup.querySelector('input').value = '';
        
        const btn = newGroup.querySelector('button');
        btn.textContent = '-';
        btn.style.backgroundColor = '#ef4444';
        btn.onclick = function() { removeEditInput(this); };
        
        container.appendChild(newGroup);
    }

    function removeEditInput(btn) {
        btn.parentElement.remove();
    }
</script>
@endsection
