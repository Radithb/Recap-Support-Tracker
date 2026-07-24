@extends('layouts.app')

@section('page_title', __('messages.title_riwayat'))
@section('page_subtitle', 'SAKTI Desk')


@section('content')
<div class="pelapor-panel active">
    {{-- SKELETON LOADING STATE --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="height: 100px; width: 100%; margin-bottom: 22px;"></div>
        <div class="skel" style="height: 300px; width: 100%;"></div>
    </div>

    {{-- ACTUAL CONTENT --}}
    <div class="content-wrap" id="actual-content" style="display:none;">
        @if(session('success'))
            <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
            </div>
        @endif

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
        <div class="modal-foot" style="display: flex; gap: 12px; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--line);">
            @if($t->status === \App\Enums\TicketStatus::OPEN)
                <button type="button" class="btn btn-danger" onclick="closeModal('modal-detail-{{ $t->ticket_id }}'); openModal('modal-delete-{{ $t->ticket_id }}')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    {{ __('messages.hapus_laporan') }}
                </button>
            @else
                <div></div>
            @endif
            <button type="button" class="btn btn-ghost" onclick="closeModal('modal-detail-{{ $t->ticket_id }}')">{{ __('messages.btn_tutup') }}</button>
        </div>
    </div>
</div>

@if($t->status === \App\Enums\TicketStatus::OPEN)
<div class="overlay" id="modal-delete-{{ $t->ticket_id }}">
    <div class="modal w-sm">
        <div class="modal-head" style="border-bottom: 1px solid var(--line); padding-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: #fef2f2; color: #ef4444; padding: 8px; border-radius: 8px; display: flex;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 2px; color: var(--ink);">{{ __('messages.title_konfirmasi_hapus') }}</h3>
                    <p class="mono" style="font-size: 0.8rem; color: var(--text-muted);">{{ $t->ticket_id }}</p>
                </div>
            </div>
            <button type="button" class="modal-x" onclick="closeModal('modal-delete-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <p style="margin: 0; font-size: 0.95rem; line-height: 1.5; color: var(--ink-soft);">
                {{ __('messages.konfirmasi_hapus_tiket') }} {{ __('messages.tindakan_tidak_dapat_dibatalkan') }}
            </p>
        </div>
        <div class="modal-foot" style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--line);">
            <button type="button" class="btn btn-ghost" onclick="closeModal('modal-delete-{{ $t->ticket_id }}'); openModal('modal-detail-{{ $t->ticket_id }}')">{{ __('messages.batal') }}</button>
            <form action="{{ route('pelapor.tickets.destroy', $t->ticket_id) }}" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    {{ __('messages.hapus_laporan') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endif
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
