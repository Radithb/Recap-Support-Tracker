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
        <div class="alert-dismiss" style="background-color: #10b981; color: white; padding: 10px 15px; border-radius: 4px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="implementasi-table">
            <thead>
                <tr>
                    <th>No. Impl</th>
                    <th>Koperasi</th>
                    <th>Aplikasi</th>
                    <th>PIC Koperasi</th>
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
                        <td>{{ $impl->aplikasi->nama_aplikasi ?? '-' }}</td>
                        <td>{{ $impl->pic_koperasi ?? '-' }}</td>
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
                            <a href="{{ route('implementasi.show', $impl->id) }}" class="btn-action">Detail</a>
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
                    <select name="aplikasi_id" class="form-control" required>
                        <option value="">Pilih Aplikasi</option>
                        @foreach($aplikasis as $app)
                            <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                        @endforeach
                    </select>
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
                        <input type="text" name="anggota_hadir" class="form-control" required placeholder="Contoh: Budi, Andi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Trainer</label>
                        <input type="text" name="nama_trainer" class="form-control" placeholder="Opsional">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">PIC Koperasi</label>
                        <input type="text" name="pic_koperasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp PIC</label>
                        <input type="text" name="kontak_pic" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email PIC</label>
                    <input type="email" name="email_pic" class="form-control">
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

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
</script>
@endsection
