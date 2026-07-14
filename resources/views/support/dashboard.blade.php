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
                        'Open', 'Proses' => 'status-open',
                        'Pending' => 'status-pending',
                        'Done' => 'status-done',
                        default => ''
                    };
                @endphp
                <span class="status {{ $statusClass }}">{{ $t->status }}</span>
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
                                <option value="Open" {{ $t->status == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="Proses" {{ $t->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Pending" {{ $t->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Done" {{ $t->status == 'Done' ? 'selected' : '' }}>Done</option>
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
