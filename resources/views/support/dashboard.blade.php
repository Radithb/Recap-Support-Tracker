@extends('layouts.app')

@section('content')

<div class="pelapor-panel active">

{{-- ═══════════════════════════════════════════ --}}
{{-- SKELETON LOADING STATE                      --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="skeleton-wrap" id="skeleton-loading">
    {{-- Page Head Skeleton --}}
    <div class="skel-page-head">
        <div>
            <div class="skel skel-page-head-eyebrow"></div>
            <div class="skel skel-page-head-title"></div>
        </div>
        <div class="skel skel-page-head-btn"></div>
    </div>

    {{-- Toolbar Skeleton --}}
    <div class="skel-toolbar">
        <div class="skel skel-toolbar-search"></div>
        <div class="skel skel-toolbar-chip"></div>
        <div class="skel skel-toolbar-chip"></div>
        <div class="skel skel-toolbar-chip"></div>
    </div>

    {{-- Table Skeleton --}}
    <div class="skel-table">
        <div class="skel-table-head">
            <div class="skel skel-table-head-cell" style="width:80px;"></div>
            <div class="skel skel-table-head-cell" style="width:70px;"></div>
            <div class="skel skel-table-head-cell" style="width:140px;"></div>
            <div class="skel skel-table-head-cell" style="flex:1;"></div>
            <div class="skel skel-table-head-cell" style="width:70px;"></div>
            <div class="skel skel-table-head-cell" style="width:80px;"></div>
        </div>
        @for($i = 0; $i < 5; $i++)
        <div class="skel-table-row">
            <div class="skel skel-table-cell" style="width:80px;"></div>
            <div class="skel skel-table-cell" style="width:70px;"></div>
            <div class="skel skel-table-cell" style="width:140px;"></div>
            <div class="skel skel-table-cell" style="flex:1;"></div>
            <div class="skel skel-table-cell" style="width:68px; border-radius:100px;"></div>
            <div class="skel skel-table-cell" style="width:80px;"></div>
        </div>
        @endfor
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ACTUAL CONTENT                              --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="content-wrap" id="actual-content" style="display: none;">

<div class="page-head fade-up" style="animation-delay: 0.1s;">
    <div>
        <p class="eyebrow">Dashboard Support</p>
        <h1>Manajemen Laporan</h1>
    </div>
    <div>
        <a href="{{ route('support.recap') }}" class="btn btn-amber">Buka Menu Rekapitulasi</a>
    </div>
</div>

<div class="toolbar fade-up" style="animation-delay: 0.15s;">
    <div class="search">
        <span style="opacity:0.5">🔍</span>
        <input type="text" placeholder="Cari tiket, instansi..." style="border:none; background:transparent; width:100%; outline:none;" id="search-input">
    </div>
    <form id="filter-form" action="{{ route('support.dashboard') }}" method="GET" style="margin:0;">
        <select name="status" onchange="document.getElementById('filter-form').submit()" style="padding: 8px 14px; border-radius: 8px; border: 1px solid var(--line); font-family: var(--font-body); font-weight: 500; color: var(--ink); background: var(--paper-raised); cursor: pointer; outline:none;">
            <option value="">Semua Status</option>
            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>
</div>

@if($pendingUsers->count() > 0)
<div class="notif-banner fade-up" style="animation-delay: 0.2s;">
    <div class="notif-icon">🔔</div>
    <div class="notif-body">
        <strong>Permintaan Verifikasi Akun <span class="notif-count">{{ $pendingUsers->count() }}</span></strong>
        <span>Ada {{ $pendingUsers->count() }} akun pelapor baru yang menunggu persetujuan Anda.</span>
    </div>
    <button class="btn btn-amber btn-sm" onclick="openModal('modal-verify')">Lihat & Verifikasi</button>
</div>
@endif

<div class="fade-up" style="animation-delay: 0.25s; overflow-x: auto; width: 100%;">
<table class="tickets" id="tickets-table" style="min-width: 1100px;">
    <thead>
        <tr>
            <th style="text-transform: uppercase;">Tiket</th>
            <th style="text-transform: uppercase;">Nama Koperasi</th>
            <th style="text-transform: uppercase;">PIC Koperasi</th>
            <th style="text-transform: uppercase;">Aplikasi</th>
            <th style="text-transform: uppercase;">Kategori</th>
            <th style="text-transform: uppercase;">PIC Support</th>
            <th width="100" style="text-transform: uppercase;">Status</th>
            <th width="120" style="text-transform: uppercase;">Tanggal</th>
            <th width="80"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $t)
        <tr>
            <td class="mono" style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">{{ $t->ticket_id }}</td>
            <td style="font-weight: 500; color: var(--ink); font-size: 0.9rem; white-space: nowrap;">{{ $t->pelapor->instansi->nama_instansi ?? '-' }}</td>
            <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                    @php
                        $nameParts = explode(' ', $t->pelapor->nama ?? 'U');
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                    @endphp
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div style="font-weight: 500; color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">{{ $t->pelapor->nama ?? '-' }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); opacity: 0.8;">{{ $t->pelapor->instansi->no_telp ?? '-' }}</div>
                    </div>
                </div>
            </td>
            <td style="color: var(--text-muted); font-size: 0.9rem; white-space: nowrap;">{{ $t->aplikasi->nama_aplikasi ?? '-' }}</td>
            <td>
                @if($t->kategori)
                    <span style="display: inline-block; white-space: nowrap; background: #ffe4e6; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; color: #be123c; border: none; text-transform: uppercase;">
                        {{ $t->kategori->nama_kategori }}
                    </span>
                @else
                    -
                @endif
            </td>
            <td>
                @if($t->picSupport)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @php
                            $picParts = explode(' ', $t->picSupport->nama);
                            $picInitials = strtoupper(substr($picParts[0], 0, 1) . (isset($picParts[1]) ? substr($picParts[1], 0, 1) : ''));
                        @endphp
                        <div style="width: 28px; height: 28px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600;">
                            {{ $picInitials }}
                        </div>
                        <span style="font-weight: 500; color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">{{ $t->picSupport->nama }}</span>
                    </div>
                @else
                    -
                @endif
            </td>
            <td>
                @php
                    $statusClass = match($t->status) {
                        \App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES => 'status-open',
                        \App\Enums\TicketStatus::PENDING => 'status-pending',
                        \App\Enums\TicketStatus::DONE => 'status-done',
                        default => ''
                    };
                @endphp
                <span class="status {{ $statusClass }}">{{ $t->status->value ?? $t->status }}</span>
            </td>
            <td class="mono" style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">
                {{ $t->tanggal_input->format('d M Y') }}
            </td>
            <td>
                <button class="btn btn-ghost btn-sm" onclick="openModal('modal-edit-{{ $t->ticket_id }}')">Respons</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</div>

<!-- Modals for Tickets -->
@foreach($tickets as $t)
<div class="overlay" id="modal-edit-{{ $t->ticket_id }}">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>Tindak Lanjut Tiket</h3><p>{{ $t->ticket_id }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-edit-{{ $t->ticket_id }}')">✕</button>
        </div>
        <form action="{{ route('support.tickets.update', $t->ticket_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="field"><label>Aplikasi</label><input type="text" value="{{ $t->aplikasi->nama_aplikasi }}" readonly></div>
                <div class="field"><label>Permasalahan</label><textarea readonly>{{ $t->permasalahan }}</textarea></div>
                @if($t->lampiran)
                <div class="field" style="margin-top: 14px;">
                    <label>Lampiran Bukti</label>
                    @php $ext = strtolower(pathinfo($t->lampiran, PATHINFO_EXTENSION)); @endphp
                    @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                        <a href="{{ Storage::url($t->lampiran) }}" target="_blank">
                            <img src="{{ Storage::url($t->lampiran) }}" alt="Lampiran" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid var(--line); display: block; margin-top: 8px; object-fit: cover;">
                        </a>
                        <div class="helper" style="margin-top: 4px;">Klik gambar untuk memperbesar.</div>
                    @elseif($ext === 'mp4')
                        <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 8px; text-decoration: none;">
                            <span>🎥</span> Lihat Bukti Video
                        </a>
                    @elseif($ext === 'pdf')
                        <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid var(--line); margin-top: 8px; text-decoration: none;">
                            <span>📄</span> Unduh Dokumen PDF
                        </a>
                    @endif
                </div>
                @endif
                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <option value="">Pilih Kategori...</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->kategori_id }}" {{ $t->kategori_id == $kat->kategori_id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Open" {{ $t->status === \App\Enums\TicketStatus::OPEN ? 'selected' : '' }}>Open</option>
                        <option value="Proses" {{ $t->status === \App\Enums\TicketStatus::PROSES ? 'selected' : '' }}>Proses</option>
                        <option value="Pending" {{ $t->status === \App\Enums\TicketStatus::PENDING ? 'selected' : '' }}>Pending</option>
                        <option value="Done" {{ $t->status === \App\Enums\TicketStatus::DONE ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div class="field">
                    <label>Penyelesaian / Catatan</label>
                    <textarea name="penyelesaian">{{ $t->penyelesaian }}</textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-edit-{{ $t->ticket_id }}')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Verifikasi Akun -->
@if($pendingUsers->count() > 0)
<div class="overlay" id="modal-verify">
    <div class="modal w-lg">
        <div class="modal-head">
            <div>
                <h3>Verifikasi Akun Pelapor</h3>
                <p>Setujui atau tolak akun yang mendaftar</p>
            </div>
            <button type="button" class="modal-x" onclick="closeModal('modal-verify')">✕</button>
        </div>
        <div class="modal-body" style="padding:0; overflow-x:auto;">
            <table class="verify-table">
                <thead>
                    <tr>
                        <th>Nama PIC</th>
                        <th>Email</th>
                        <th>Instansi</th>
                        <th>No. HP</th>
                        <th>Tgl Daftar</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $pu)
                    <tr>
                        <td style="font-weight:600;">{{ $pu->nama }}</td>
                        <td class="mono">{{ $pu->email }}</td>
                        <td>{{ $pu->instansi->nama_instansi ?? '-' }}</td>
                        <td class="mono">{{ $pu->instansi->no_telp ?? '-' }}</td>
                        <td class="mono">{{ $pu->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="verify-actions">
                                <form action="{{ route('support.users.verify', $pu->user_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui akun ini">✓ Setujui</button>
                                </form>
                                <form action="{{ route('support.users.reject', $pu->user_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak dan menghapus akun {{ $pu->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak dan hapus akun">✕ Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-ghost" onclick="closeModal('modal-verify')">Tutup</button>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');
        setTimeout(function () {
            skeleton.style.display = 'none';
            content.style.display = 'block';
            content.classList.add('loaded');
        }, 1200);

        document.getElementById('search-input').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tickets-table tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                if(text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
</div>
@endsection
