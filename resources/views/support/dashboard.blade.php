@extends('layouts.app')

@section('content')
<div class="page-head">
    <div>
        <p class="eyebrow">Dashboard Support</p>
        <h1>Manajemen Laporan</h1>
    </div>
    <div>
        <a href="{{ route('support.recap') }}" class="btn btn-amber">Buka Menu Rekapitulasi</a>
    </div>
</div>

<div class="toolbar">
    <div class="search">
        <span style="opacity:0.5">🔍</span>
        <input type="text" placeholder="Cari tiket, instansi..." style="border:none; background:transparent; width:100%; outline:none;" id="search-input">
    </div>
    <a href="{{ route('support.dashboard') }}" class="chip-filter {{ !request('status') ? 'active' : '' }}">Semua Tiket</a>
    <a href="{{ route('support.dashboard', ['status' => 'Open']) }}" class="chip-filter {{ request('status') == 'Open' ? 'active' : '' }}">Open</a>
    <a href="{{ route('support.dashboard', ['status' => 'Proses']) }}" class="chip-filter {{ request('status') == 'Proses' ? 'active' : '' }}">Proses</a>
</div>

@if($pendingUsers->count() > 0)
<div class="notif-banner">
    <div class="notif-icon">🔔</div>
    <div class="notif-body">
        <strong>Permintaan Verifikasi Akun <span class="notif-count">{{ $pendingUsers->count() }}</span></strong>
        <span>Ada {{ $pendingUsers->count() }} akun pelapor baru yang menunggu persetujuan Anda.</span>
    </div>
    <button class="btn btn-amber btn-sm" onclick="openModal('modal-verify')">Lihat & Verifikasi</button>
</div>
@endif

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

        <!-- Modal Update Status Support -->
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
    </tbody>
</table>

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
</script>
@endsection
