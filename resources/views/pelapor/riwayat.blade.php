@extends('layouts.app')

@section('page_title', 'Riwayat Lengkap Laporan')
@section('page_subtitle', 'Recap Support Tracker')

@section('sidebar_menu')
    <a href="{{ route('pelapor.dashboard') }}">
        <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> Dashboard
    </a>
    <a href="{{ route('pelapor.riwayat') }}" class="active">
        <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> Riwayat Lengkap
    </a>
@endsection

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
                <h1 style="font-size:24px;">Semua Riwayat Laporan</h1>
            </div>
        </div>

        <div class="toolbar fade-up" style="animation-delay: 0.15s; margin-bottom:20px;">
            <div class="search">
                <span style="opacity:0.5">🔍</span>
                <input type="text" placeholder="Cari laporan..." style="border:none; background:transparent; width:100%; outline:none;" id="search-input">
            </div>
            <form id="filter-form" action="{{ route('pelapor.riwayat') }}" method="GET" style="margin:0;">
                <select name="status" onchange="document.getElementById('filter-form').submit()" style="padding: 8px 14px; border-radius: 8px; border: 1px solid var(--line); font-family: var(--font-body); font-weight: 500; color: var(--ink); background: var(--paper-raised); cursor: pointer; outline:none;">
                    <option value="">Semua Status</option>
                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
        </div>

        <div class="fade-up" style="animation-delay: 0.2s;">
            <table class="tickets">
                <thead>
                    <tr>
                        <th width="120">ID Laporan</th>
                        <th width="120">Tanggal</th>
                        <th width="180">Aplikasi</th>
                        <th>Permasalahan</th>
                        <th width="120">Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $t)
                    <tr>
                        <td class="mono">#{{ $t->ticket_id }}</td>
                        <td class="mono">{{ $t->tanggal_input->format('d M y') }}</td>
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
                            <button class="btn btn-ghost btn-sm" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:var(--ink-soft);">
                            Belum ada tiket laporan.
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
            <div class="field"><label>Penyelesaian Support</label><textarea readonly>{{ $t->penyelesaian ?? 'Belum ada catatan penyelesaian.' }}</textarea></div>
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
    });
</script>
@endsection
