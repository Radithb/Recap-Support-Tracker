@extends('layouts.app')

@section('content')
<div class="cta-band">
    <div>
        <h2>Ada kendala aplikasi hari ini?</h2>
        <p>Laporkan sekali, pantau statusnya real-time — tim kami menindaklanjuti setiap tiket dari lapor hingga selesai.</p>
    </div>
    <button class="btn btn-amber" onclick="openModal('modal-create')">＋ Buat Laporan Baru</button>
</div>

<!-- Statistik Sederhana -->
<div class="stat-row">
    <div class="stat-card"><div class="n" style="color:var(--clay)">{{ $tickets->whereIn('status', [\App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES])->count() }}</div><div class="l">Open / Proses</div></div>
    <div class="stat-card"><div class="n" style="color:#B8923F">{{ $tickets->where('status', \App\Enums\TicketStatus::PENDING)->count() }}</div><div class="l">Pending — butuh info</div></div>
    <div class="stat-card"><div class="n" style="color:var(--sage)">{{ $tickets->where('status', \App\Enums\TicketStatus::DONE)->count() }}</div><div class="l">Selesai Total</div></div>
</div>

<div class="grid2" style="grid-template-columns:2fr 1fr; align-items:start; gap:20px;">
    <div>
        <div class="page-head" style="margin-bottom:14px;">
            <div><p class="eyebrow">Dashboard Pelapor</p><h1 style="font-size:22px;">Riwayat Laporan Anda</h1></div>
        </div>
        
        <div class="ticket-list">
            @forelse($tickets as $t)
            <div class="ticket-card" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')" style="cursor:pointer">
                <div class="tid">{{ $t->ticket_id }}</div>
                <div class="main">
                    <h3>{{ $t->permasalahan }}</h3>
                    <p>{{ $t->penyelesaian ?? 'Belum ada catatan penyelesaian.' }}</p>
                </div>
                <div class="meta">{{ $t->aplikasi->nama_aplikasi }} · {{ $t->tanggal_input->format('d M Y') }}</div>
                
                @php
                    $statusClass = match($t->status) {
                        \App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES => 'status-open',
                        \App\Enums\TicketStatus::PENDING => 'status-pending',
                        \App\Enums\TicketStatus::DONE => 'status-done',
                        default => ''
                    };
                @endphp
                <span class="status {{ $statusClass }}">{{ $t->status->value ?? $t->status }}</span>
            </div>
            
            <!-- Modal Detail Ticket (Read Only for Pelapor) -->
            <div class="overlay" id="modal-ticket-{{ $t->ticket_id }}">
                <div class="modal">
                    <div class="modal-head">
                        <div><h3>Detail Laporan</h3><p>{{ $t->ticket_id }}</p></div>
                        <button type="button" class="modal-x" onclick="closeModal('modal-ticket-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
                    </div>
                    <div class="modal-body">
                        <div class="field"><label>Aplikasi</label><input type="text" value="{{ $t->aplikasi->nama_aplikasi }}" readonly></div>
                        <div class="field"><label>Kategori</label><input type="text" value="{{ $t->kategori->nama_kategori ?? '-' }}" readonly></div>
                        <div class="field"><label>Permasalahan</label><textarea readonly>{{ $t->permasalahan }}</textarea></div>
                        <div class="field"><label>Penyelesaian Support</label><textarea readonly>{{ $t->penyelesaian }}</textarea></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="ticket-card" style="justify-content:center; padding:30px;">
                <p class="eyebrow">Belum ada tiket laporan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Profil Instansi -->
    <div class="panel" style="padding:16px 18px;">
        <h4 style="display:flex; align-items:center; gap:6px;">🏢 Profil Instansi</h4>
        <p class="sub" style="margin-bottom:10px;">Data INSTANSI · terhubung ke akun Anda</p>
        <div style="font-size:12.5px; line-height:1.9; color:var(--ink-soft);">
            <div><strong style="color:var(--ink);">{{ Auth::user()->instansi->nama_instansi ?? '-' }}</strong></div>
            <div>{{ Auth::user()->instansi->alamat ?? '-' }}</div>
            <div class="mono">{{ Auth::user()->instansi->no_telp ?? '-' }}</div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="overlay" id="modal-create">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>Buat Laporan Baru</h3><p>Jelaskan kendala Anda</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-create')">✕</button>
        </div>
        <form action="{{ route('pelapor.tickets.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>Aplikasi Bermasalah</label>
                    <select name="aplikasi_id" required>
                        <option value="">Pilih Aplikasi...</option>
                        @foreach($aplikasis as $app)
                            <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Deskripsi Kendala</label>
                    <textarea name="permasalahan" required placeholder="Tuliskan secara detail..."></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-create')">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection
