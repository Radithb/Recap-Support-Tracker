@extends('layouts.app')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Recap Support Tracker')


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
                <h2>{{ __('messages.halo') }}, {{ Auth::user()->nama ?? 'User' }}!</h2>
                <p>{{ __('messages.selamat_datang') }}</p>
            </div>
        </div>

        <div class="cta-band fade-up" style="animation-delay: 0.15s;">
            <div>
                <h2>{{ __('messages.ada_kendala') }}</h2>
                <p>{{ __('messages.laporkan_sekali') }}</p>
            </div>
            <button class="btn btn-amber" onclick="openModal('modal-create')">＋ {{ __('messages.buat_laporan_baru') }}</button>
        </div>

        <!-- Statistik Sederhana -->
        <div class="stat-row fade-up" style="animation-delay: 0.2s;">
            <div class="stat-card"><div class="n" style="color:var(--clay)">{{ $totalOpen }}</div><div class="l">{{ __('messages.open_proses') }}</div></div>
            <div class="stat-card"><div class="n" style="color:#B8923F">{{ $totalPending }}</div><div class="l">{{ __('messages.pending_butuh_info') }}</div></div>
            <div class="stat-card"><div class="n" style="color:var(--sage)">{{ $totalDone }}</div><div class="l">{{ __('messages.selesai_total') }}</div></div>
        </div>

        <div class="fade-up" style="animation-delay: 0.25s;">
            <div>
                <div class="page-head" style="margin-bottom:14px;">
                    <div><h1 style="font-size: calc(22px * var(--text-scale, 1));">{{ __('messages.riwayat_laporan_anda') }}</h1></div>
                </div>
                
                <div class="ticket-list">
                    @forelse($tickets as $t)
                    <div class="ticket-card fade-up" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')" style="cursor:pointer; animation-delay: {{ 0.3 + ($loop->index * 0.08) }}s;">
                        <div class="tid">{{ $t->ticket_id }}</div>
                        <div class="main">
                            <h3>{{ $t->permasalahan }}</h3>
                            <p>{{ $t->penyelesaian ?? __('messages.belum_ada_catatan') }}</p>
                        </div>
                        <div class="meta">{{ $t->aplikasi->nama_aplikasi }} &middot; {{ $t->tanggal_input->format('d M Y') }} &middot; {{ $t->tanggal_input->format('H:i') }}</div>
                        
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
                        <p class="eyebrow">{{ __('messages.belum_ada_tiket_laporan') }}</p>
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
            <div><h3>{{ __('messages.detail_laporan') }}</h3><p>{{ $t->ticket_id }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-ticket-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
        </div>
        <div class="modal-body">
            <div class="field"><label>{{ __('messages.aplikasi') }}</label><input type="text" value="{{ $t->aplikasi->nama_aplikasi }}" readonly></div>
            <div class="field"><label>{{ __('messages.kategori') }}</label><input type="text" value="{{ $t->kategori->nama_kategori ?? '-' }}" readonly></div>
            <div class="field"><label>{{ __('messages.permasalahan') }}</label><textarea readonly>{{ $t->permasalahan }}</textarea></div>
            @if($t->lampiran)
            <div class="field" style="margin-top: 14px;">
                <label>{{ __('messages.lampiran_bukti') }}</label>
                @php $ext = strtolower(pathinfo($t->lampiran, PATHINFO_EXTENSION)); @endphp
                @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank">
                        <img src="{{ Storage::url($t->lampiran) }}" alt="Lampiran" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid var(--line); display: block; margin-top: 8px; object-fit: cover;">
                    </a>
                    <div class="helper" style="margin-top: 4px;">{{ __('messages.klik_gambar') }}</div>
                @elseif($ext === 'mp4')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 8px; text-decoration: none;">
                        <span>🎥</span> {{ __('messages.lihat_video') }}
                    </a>
                @elseif($ext === 'pdf')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid var(--line); margin-top: 8px; text-decoration: none;">
                        <span>📄</span> {{ __('messages.unduh_pdf') }}
                    </a>
                @endif
            </div>
            @endif
            <div class="field"><label>{{ __('messages.penyelesaian_support') }}</label><textarea readonly>{{ $t->penyelesaian }}</textarea></div>
            <div class="field"><label>{{ __('messages.tindakan_pencegahan') }}</label><textarea readonly>{{ $t->pencegahan ?? '-' }}</textarea></div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Create -->
<div class="overlay" id="modal-create">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>{{ __('messages.buat_laporan_baru') }}</h3><p>{{ __('messages.jelaskan_kendala') }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-create')">✕</button>
        </div>
        <form action="{{ route('pelapor.tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>{{ __('messages.aplikasi_bermasalah') }}</label>
                    <select name="aplikasi_id" required>
                        <option value="">{{ __('messages.pilih_aplikasi') }}</option>
                        @foreach($aplikasis as $app)
                            <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>{{ __('messages.deskripsi_kendala') }}</label>
                    <textarea name="permasalahan" required placeholder="{{ __('messages.tuliskan_detail') }}"></textarea>
                </div>
                <div class="field" style="margin-top: 14px;">
                    <label>Upload Lampiran (Opsional)</label>
                    <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.mp4,.pdf" style="width:100%; font-size: calc(13px * var(--text-scale, 1)); font-family:var(--font-body); padding:8px; border:1.5px dashed var(--line); border-radius:8px; background:var(--paper); cursor:pointer;">
                    <div class="helper">Format: JPG, PNG, MP4, PDF (Maksimal 5MB)</div>
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
