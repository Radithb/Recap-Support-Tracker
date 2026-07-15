@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════ --}}
{{-- SKELETON LOADING STATE                      --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="skeleton-wrap" id="skeleton-loading">
    <div class="skel-cta">
        <div class="skel-cta-text">
            <div class="skel skel-cta-line"></div>
            <div class="skel skel-cta-line-sm"></div>
        </div>
        <div class="skel skel-cta-btn"></div>
    </div>

    <div class="skel-stat-row">
        @for($i = 0; $i < 3; $i++)
        <div class="skel-stat-card">
            <div class="skel skel-stat-n"></div>
            <div class="skel skel-stat-l"></div>
        </div>
        @endfor
    </div>

    <div class="skel-grid">
        <div>
            <div class="skel skel-head-eyebrow"></div>
            <div class="skel skel-head-title"></div>
            @for($i = 0; $i < 3; $i++)
            <div class="skel-ticket">
                <div class="skel skel-ticket-id"></div>
                <div class="skel-ticket-main">
                    <div class="skel skel-ticket-h3"></div>
                    <div class="skel skel-ticket-p"></div>
                </div>
                <div class="skel skel-ticket-meta"></div>
                <div class="skel skel-ticket-badge"></div>
            </div>
            @endfor
        </div>
        <div class="skel-panel">
            <div class="skel skel-panel-title"></div>
            <div class="skel skel-panel-sub"></div>
            <div class="skel skel-panel-line"></div>
            <div class="skel skel-panel-line"></div>
            <div class="skel skel-panel-line"></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ACTUAL CONTENT                              --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="content-wrap" id="actual-content">

    <div class="cta-band fade-up" style="animation-delay: 0.1s;">
        <div>
            <h2>Ada kendala aplikasi hari ini?</h2>
            <p>Laporkan sekali, pantau statusnya real-time — tim kami menindaklanjuti setiap tiket dari lapor hingga selesai.</p>
        </div>
        <button class="btn btn-amber" onclick="openModal('modal-create')">＋ Buat Laporan Baru</button>
    </div>

    <!-- Statistik Sederhana -->
    <div class="stat-row fade-up" style="animation-delay: 0.2s;">
        <div class="stat-card"><div class="n" style="color:var(--clay)">{{ $tickets->whereIn('status', [\App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES])->count() }}</div><div class="l">Open / Proses</div></div>
        <div class="stat-card"><div class="n" style="color:#B8923F">{{ $tickets->where('status', \App\Enums\TicketStatus::PENDING)->count() }}</div><div class="l">Pending — butuh info</div></div>
        <div class="stat-card"><div class="n" style="color:var(--sage)">{{ $tickets->where('status', \App\Enums\TicketStatus::DONE)->count() }}</div><div class="l">Selesai Total</div></div>
    </div>

    <div class="grid2 fade-up" style="grid-template-columns:2fr 1fr; align-items:start; gap:20px; animation-delay: 0.3s;">
        <div>
            <div class="page-head" style="margin-bottom:14px;">
                <div><p class="eyebrow">Dashboard Pelapor</p><h1 style="font-size:22px;">Riwayat Laporan Anda</h1></div>
            </div>
            
            <div class="ticket-list">
                @forelse($tickets as $t)
                <div class="ticket-card fade-up" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')" style="cursor:pointer; animation-delay: {{ 0.35 + ($loop->index * 0.08) }}s;">
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
                

                @empty
                <div class="ticket-card" style="justify-content:center; padding:30px;">
                    <p class="eyebrow">Belum ada tiket laporan.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Profil Instansi -->
        <div class="panel fade-up" style="padding:16px 18px; animation-delay: 0.4s;">
            <h4 style="display:flex; align-items:center; gap:6px;">🏢 Profil Instansi</h4>
            <p class="sub" style="margin-bottom:10px;">Data INSTANSI · terhubung ke akun Anda</p>
            <div style="font-size:12.5px; line-height:1.9; color:var(--ink-soft);">
                <div><strong style="color:var(--ink);">{{ Auth::user()->instansi->nama_instansi ?? '-' }}</strong></div>
                <div>{{ Auth::user()->instansi->alamat ?? '-' }}</div>
                <div class="mono">{{ Auth::user()->instansi->no_telp ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Tickets -->
@foreach($tickets as $t)
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
@endforeach

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');
        setTimeout(function () {
            skeleton.style.display = 'none';
            content.classList.add('loaded');
        }, 1200);
    });
</script>
@endsection
