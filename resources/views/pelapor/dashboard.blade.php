@extends('layouts.app')

@section('page_title', 'Dashboard Pelapor')
@section('page_subtitle', 'Recap Support Tracker')

@section('sidebar_menu')
    <a href="{{ route('pelapor.dashboard') }}" class="active">
        <span class="ic">🏠</span> Beranda Pelapor
    </a>
    <a href="{{ route('pelapor.riwayat') }}">
        <span class="ic">📋</span> Riwayat Lengkap
    </a>
@endsection

@section('content')
<div class="pelapor-panel active">
    {{-- SKELETON LOADING STATE --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="height: 100px; width: 100%; margin-bottom: 22px;"></div>
        <div class="skel" style="height: 120px; width: 100%; margin-bottom: 28px;"></div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px;">
            <div class="skel" style="height: 100px;"></div>
            <div class="skel" style="height: 100px;"></div>
            <div class="skel" style="height: 100px;"></div>
        </div>
        <div>
            <div class="skel" style="height: 30px; width: 40%; margin-bottom: 14px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
        </div>
    </div>

    {{-- ACTUAL CONTENT --}}
    <div class="content-wrap" id="actual-content" style="display:none;">
        <div class="welcome-banner fade-up" style="animation-delay: 0.1s;">
            <div class="wave">👋</div>
            <div>
                <h2>Halo, {{ Auth::user()->nama ?? 'User' }}!</h2>
                <p>Selamat datang di Recap Support Tracker. Bagaimana kami bisa membantu hari ini?</p>
            </div>
        </div>

        <div class="cta-band fade-up" style="animation-delay: 0.15s;">
            <div>
                <h2>Ada kendala aplikasi hari ini?</h2>
                <p>Laporkan sekali, pantau statusnya real-time — tim kami menindaklanjuti setiap tiket dari lapor hingga selesai.</p>
            </div>
            <button class="btn btn-amber" onclick="openModal('modal-create')">＋ Buat Laporan Baru</button>
        </div>

        <!-- Statistik Sederhana -->
        <div class="stat-row fade-up" style="animation-delay: 0.2s;">
            <div class="stat-card"><div class="n" style="color:var(--clay)">{{ $totalOpen }}</div><div class="l">Open / Proses</div></div>
            <div class="stat-card"><div class="n" style="color:#B8923F">{{ $totalPending }}</div><div class="l">Pending — butuh info</div></div>
            <div class="stat-card"><div class="n" style="color:var(--sage)">{{ $totalDone }}</div><div class="l">Selesai Total</div></div>
        </div>

        <div class="fade-up" style="animation-delay: 0.25s;">
            <div>
                <div class="page-head" style="margin-bottom:14px;">
                    <div><h1 style="font-size:22px;">Riwayat Laporan Anda</h1></div>
                </div>
                
                <div class="ticket-list">
                    @forelse($tickets as $t)
                    <div class="ticket-card fade-up" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')" style="cursor:pointer; animation-delay: {{ 0.3 + ($loop->index * 0.08) }}s;">
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
        </div>
    </div>
</div>

<!-- Modals for Tickets -->
@foreach($tickets as $t)
<div class="overlay" id="modal-ticket-{{ $t->ticket_id }}">
    <div class="modal w-sm">
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
        
        // Use a simple mechanism to wait 1.2s then show content
        setTimeout(function () {
            if(skeleton) skeleton.style.display = 'none';
            if(content) content.style.display = 'block';
        }, 1200);
    });
</script>
@endsection
