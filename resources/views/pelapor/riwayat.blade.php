@extends('layouts.app')

@section('page_title', __('messages.title_riwayat'))
@section('page_subtitle', 'Recap Support Tracker')


@section('content')
<div class="pelapor-panel active">
    {{-- SKELETON LOADING STATE --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="height: 100px; width: 100%; margin-bottom: 22px;"></div>
        <div class="skel" style="height: 300px; width: 100%;"></div>
    </div>

    {{-- ACTUAL CONTENT --}}
    <div class="content-wrap" id="actual-content" style="display:none;">
        <div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom:24px;">
            <div>
                <h1 style="font-size: calc(24px * var(--text-scale, 1));">{{ __('messages.title_riwayat') }}</h1>
            </div>
        </div>

        <div class="toolbar fade-up" style="animation-delay: 0.15s; margin-bottom:20px;">
            <div class="search">
                <img src="{{ asset('magnifying-glass.png') }}" alt="Search" style="width: 14px; height: 14px; margin-right: 8px; vertical-align: middle; opacity: 0.4; filter: grayscale(100%);">
                <input type="text" placeholder="{{ __('messages.cari_laporan') }}" style="border:none; background:transparent; width:100%; outline:none;" id="search-input">
            </div>
            <form id="filter-form" action="{{ route('pelapor.riwayat') }}" method="GET" style="margin:0;">
                <select name="status" onchange="document.getElementById('filter-form').submit()" style="padding: 8px 14px; border-radius: 8px; border: 1px solid var(--line); font-family: var(--font-body); font-weight: 500; color: var(--ink); background: var(--paper-raised); cursor: pointer; outline:none;">
                    <option value="">{{ __('messages.status_semua') }}</option>
                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>{{ __('messages.status_selesai') }}</option>
                </select>
            </form>
        </div>

        <div class="fade-up" style="animation-delay: 0.2s;">
            <table class="tickets">
                <thead>
                    <tr>
                        <th width="120">{{ __('messages.id_laporan') }}</th>
                        <th width="120">{{ __('messages.col_tanggal') }}</th>
                        <th width="180">{{ __('messages.aplikasi') }}</th>
                        <th>{{ __('messages.permasalahan') }}</th>
                        <th width="120">{{ __('messages.status') }}</th>
                        <th width="100">{{ __('messages.aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $t)
                    <tr class="clickable-row hoverable-row" data-target="modal-preview-{{ $t->ticket_id }}" style="cursor: pointer;">
                        <td class="mono">#{{ $t->ticket_id }}</td>
                        <td class="mono">
                            {{ $t->tanggal_input->format('d M y') }}
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">{{ $t->tanggal_input->format('H:i') }}</div>
                        </td>
                        <td><div class="cat-tag">{{ $t->aplikasi->nama_aplikasi }}</div></td>
                        <td><div style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500;">{{ $t->permasalahan }}</div></td>
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
                            <button class="btn btn-ghost btn-sm" onclick="openModal('modal-detail-{{ $t->ticket_id }}')">{{ __('messages.btn_detail') }}</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:var(--ink-soft);">
                            {{ __('messages.belum_ada_tiket_laporan') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals for Tickets -->
@foreach($tickets as $t)
<div class="overlay" id="modal-preview-{{ $t->ticket_id }}">
    <div class="modal w-sm">
        <div class="modal-head" style="border-bottom: 1px solid var(--line); padding-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: var(--brand-primary-soft); color: var(--primary); padding: 8px; border-radius: 8px; display: flex;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 2px; color: var(--ink);">{{ __('messages.modal_preview_title') }}</h3>
                    <p class="mono" style="font-size: 0.8rem; color: var(--text-muted);">{{ $t->ticket_id }}</p>
                </div>
            </div>
            <button type="button" class="modal-x" onclick="closeModal('modal-preview-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
        </div>
        
        <div class="modal-body" style="padding: 24px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: #1d4ed8; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-bottom: 20px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                {{ __('messages.disubmit') }} {{ \Carbon\Carbon::parse($t->tanggal_input->format('Y-m-d H:i:s'), 'Asia/Jakarta')->locale(app()->getLocale())->diffForHumans(['parts' => 2]) }} &middot; {{ $t->tanggal_input->format('d M Y, H:i') }}
            </div>

            <div style="margin-bottom: 24px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('messages.deskripsi_permasalahan') }}</div>
                <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.6; white-space: pre-wrap; background: var(--paper-raised); padding: 16px; border-radius: 8px; border: 1px solid var(--line);">{{ $t->permasalahan }}</div>
            </div>

        </div>
        <div class="modal-foot" style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--line);">
            <button type="button" class="btn btn-ghost" onclick="closeModal('modal-preview-{{ $t->ticket_id }}')">{{ __('messages.btn_tutup') }}</button>
            <button type="button" class="btn btn-primary" onclick="closeModal('modal-preview-{{ $t->ticket_id }}'); openModal('modal-detail-{{ $t->ticket_id }}')">{{ __('messages.btn_detail') }}</button>
        </div>
    </div>
</div>

<div class="overlay" id="modal-detail-{{ $t->ticket_id }}">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>{{ __('messages.detail_laporan') }}</h3><p>{{ $t->ticket_id }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-detail-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
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
            <div class="field"><label>{{ __('messages.penyelesaian_support') }}</label><textarea readonly>{{ $t->penyelesaian ?? __('messages.belum_ada_catatan') }}</textarea></div>
            <div class="field"><label>{{ __('messages.tindakan_pencegahan') }}</label><textarea readonly>{{ $t->pencegahan ?? '-' }}</textarea></div>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');
        
        // Use a simple mechanism to wait 0.8s then show content
        setTimeout(function () {
            if(skeleton) skeleton.style.display = 'none';
            if(content) content.style.display = 'block';
        }, 800);

        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('button') && !e.target.closest('a')) {
                    openModal(this.getAttribute('data-target'));
                }
            });
        });
    });
</script>
@endsection
