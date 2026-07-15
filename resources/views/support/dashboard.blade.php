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
<div class="content-wrap" id="actual-content">

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

<div class="fade-up" style="animation-delay: 0.25s;">
<table class="tickets" id="tickets-table">
    <thead>
        <tr>
            <th width="100">Ticket ID</th>
            <th width="120">Tanggal</th>
            <th>Pelapor & Aplikasi</th>
            <th>Permasalahan</th>
            <th width="100">Status</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $t)
        <tr>
            <td class="mono">#{{ $t->ticket_id }}</td>
            <td class="mono">{{ $t->tanggal_input->format('d M y') }}</td>
            <td>
                <div style="font-weight:600; margin-bottom:4px; color:var(--ink)">{{ $t->pelapor->instansi->nama_instansi ?? 'Instansi' }}</div>
                <div class="cat-tag">{{ $t->aplikasi->nama_aplikasi }}</div>
            </td>
            <td>
                <div style="max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500;">{{ $t->permasalahan }}</div>
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
    <div class="modal">
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
