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
        @if(session('success'))
            <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(14px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
            </div>
        @endif

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
        <div class="modal-body" style="padding: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">{{ __('messages.aplikasi') }}</div>
                    <div style="font-size: 0.95rem; color: var(--ink); font-weight: 500;">{{ $t->aplikasi->nama_aplikasi }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">{{ __('messages.kategori') }}</div>
                    <div style="font-size: 0.95rem; color: var(--ink); font-weight: 500;">{{ $t->kategori->nama_kategori ?? '-' }}</div>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.permasalahan') }}</div>
                <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.5; white-space: pre-wrap; background: var(--paper-raised); padding: 12px; border-radius: 8px; border: 1px solid var(--line);">{{ $t->permasalahan }}</div>
            </div>

            @if($t->lampiran)
            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.lampiran_bukti') }}</div>
                @php $ext = strtolower(pathinfo($t->lampiran, PATHINFO_EXTENSION)); @endphp
                @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank">
                        <img src="{{ Storage::url($t->lampiran) }}" alt="Lampiran" style="max-width: 100%; max-height: 140px; border-radius: 8px; border: 1px solid var(--line); display: block; object-fit: cover;">
                    </a>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ __('messages.klik_gambar') }}</div>
                @elseif($ext === 'mp4')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        <span>🎥</span> {{ __('messages.lihat_video') }}
                    </a>
                @elseif($ext === 'pdf')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 6px; border: 1.5px solid var(--line); text-decoration: none;">
                        <span>📄</span> {{ __('messages.unduh_pdf') }}
                    </a>
                @endif
            </div>
            @endif

            @if($t->lampiran_support)
            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Lampiran Respons Support</div>
                @php $extSupp = strtolower(pathinfo($t->lampiran_support, PATHINFO_EXTENSION)); @endphp
                @if(in_array($extSupp, ['jpg', 'jpeg', 'png']))
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank">
                        <img src="{{ Storage::url($t->lampiran_support) }}" alt="Lampiran Support" style="max-width: 100%; max-height: 140px; border-radius: 8px; border: 1px solid var(--line); display: block; object-fit: cover;">
                    </a>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ __('messages.klik_gambar') }}</div>
                @elseif($extSupp === 'mp4')
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        <span>🎥</span> {{ __('messages.lihat_video') }}
                    </a>
                @elseif($extSupp === 'pdf')
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 6px; border: 1.5px solid var(--line); text-decoration: none;">
                        <span>📄</span> {{ __('messages.unduh_pdf') }}
                    </a>
                @endif
            </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.penyelesaian_support') }}</div>
                    @if($t->penyelesaian)
                        <div style="font-size: 0.95rem; color: #166534; line-height: 1.5; white-space: pre-wrap; background: #f0fdf4; padding: 12px; border-radius: 8px; border: 1px solid #bbf7d0;">{{ $t->penyelesaian }}</div>
                    @else
                        <div style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.5; white-space: pre-wrap; background: var(--paper-raised); padding: 12px; border-radius: 8px; border: 1px dashed var(--line);">{{ __('messages.belum_ada_catatan') }}</div>
                    @endif
                </div>
                @if($t->pencegahan)
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.tindakan_pencegahan') }}</div>
                    <div style="font-size: 0.95rem; color: #854d0e; line-height: 1.5; white-space: pre-wrap; background: #fefce8; padding: 12px; border-radius: 8px; border: 1px solid #fef08a;">{{ $t->pencegahan }}</div>
                </div>
                @endif
            </div>
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
                            <option value="{{ $app->aplikasi_id }}" {{ old('aplikasi_id') == $app->aplikasi_id ? 'selected' : '' }}>{{ $app->nama_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('aplikasi_id') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>{{ __('messages.deskripsi_kendala') }}</label>
                    <textarea name="permasalahan" required placeholder="{{ __('messages.tuliskan_detail') }}">{{ old('permasalahan') }}</textarea>
                    @error('permasalahan') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
                <div class="field" style="margin-top: 14px;">
                    <label>{{ __('messages.upload_lampiran_opsional') }}</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input type="file" id="lampiran_input" name="lampiran" accept=".jpg,.jpeg,.png,.mp4,.pdf" style="flex: 1; width:100%; font-size: calc(13px * var(--text-scale, 1)); font-family:var(--font-body); padding:8px; border:1.5px dashed var(--line); border-radius:8px; background:var(--paper); cursor:pointer;" onchange="document.getElementById('clear_lampiran_btn').style.display = this.value ? 'inline-block' : 'none';">
                        <button type="button" id="clear_lampiran_btn" style="display: none; padding: 8px 12px; background: #fee2e2; color: #ef4444; border: 1px solid #f87171; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500;" onclick="document.getElementById('lampiran_input').value = ''; this.style.display = 'none';">Hapus</button>
                    </div>
                    <div class="helper">{{ __('messages.format_lampiran') }}</div>
                    @error('lampiran') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-create')">{{ __('messages.batal') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.kirim_laporan') }}</button>
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

        @if($errors->any())
            openModal('modal-create');
        @endif
    });
</script>
@endsection
