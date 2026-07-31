@extends('layouts.app')

@section('content')

<div class="pelapor-panel active">

{{-- ═══════════════════════════════════════════ --}}
{{-- SKELETON LOADING STATE                      --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="skeleton-wrap" id="skeleton-loading">
    <div class="skel-recap-header">
        <div>
            <div class="skel" style="height:20px; width:260px; margin-bottom:8px;"></div>
            <div class="skel" style="height:12px; width:300px;"></div>
        </div>
        <div class="skel" style="height:38px; width:150px; border-radius:8px;"></div>
    </div>

    <div class="skel-recap-grid" style="grid-template-columns: 1fr;">
        <div class="skel-recap-chart" style="height: 350px;">
            <div class="skel skel-chart-title"></div>
            <div class="skel skel-chart-area"></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ACTUAL CONTENT                              --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="content-wrap" id="actual-content" style="display: none;">

@section('page_title', 'History Edit PIC')
@section('page_subtitle', 'internal.ptskk.id')

<div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 2rem; color: var(--ink); font-family: 'Poppins', sans-serif; font-weight: 700;">History Edit Tiket PIC</h1>
    </div>
</div>

{{-- FILTER CARD --}}
<div class="glass-panel fade-up" style="animation-delay: 0.15s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;">
    <form action="{{ route('support.recap.history-pic') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin: 0;">
        <div style="flex: 1; min-width: 220px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No Tiket, Koperasi, Permasalahan..." style="width: 100%; padding: 9px 14px; border-radius: 8px; border: 1px solid var(--line); font-size: 0.88rem; outline: none; background: var(--paper-sunken); color: var(--ink);">
        </div>
        <div style="min-width: 160px;">
            <select name="status" style="width: 100%; padding: 9px 14px; border-radius: 8px; border: 1px solid var(--line); font-size: 0.88rem; outline: none; background: var(--paper-sunken); color: var(--ink); cursor: pointer;">
                <option value="">-- Semua Status --</option>
                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done (Selesai)</option>
            </select>
        </div>
        <div style="min-width: 180px;">
            <select name="pic_id" style="width: 100%; padding: 9px 14px; border-radius: 8px; border: 1px solid var(--line); font-size: 0.88rem; outline: none; background: var(--paper-sunken); color: var(--ink); cursor: pointer;">
                <option value="">-- Semua PIC Support --</option>
                @foreach($supportUsers as $sup)
                    <option value="{{ $sup->user_id }}" {{ request('pic_id') == $sup->user_id ? 'selected' : '' }}>{{ $sup->nama }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary" style="padding: 9px 18px; font-weight: 600; font-size: 0.88rem; border-radius: 8px;">Cari</button>
            @if(request()->anyFilled(['search', 'status', 'pic_id']))
                <a href="{{ route('support.recap.history-pic') }}" class="btn" style="padding: 9px 14px; background: #e2e8f0; color: #475569; font-weight: 600; font-size: 0.88rem; border-radius: 8px; text-decoration: none;">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- TABLE CARD --}}
<div class="glass-panel fade-up" style="animation-delay: 0.2s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line);">
        <h3 style="margin: 0; font-size: 1.1rem; color: var(--ink); font-family: 'Poppins', sans-serif; font-weight: 700;">Riwayat Perubahan Tiket oleh PIC</h3>
        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Total {{ $tickets->total() }} Tiket</span>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
            <thead style="background: var(--paper-sunken);">
                <tr>
                    <th style="padding: 1rem 1.25rem; text-align: left; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">No Tiket & Koperasi</th>
                    <th style="padding: 1rem 1.25rem; text-align: left; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">PIC Support Editor</th>
                    <th style="padding: 1rem 1.25rem; text-align: center; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Waktu Edit Terakhir</th>
                    <th style="padding: 1rem 1.25rem; text-align: center; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $tkt)
                    @php
                        $stVal = is_object($tkt->status) ? $tkt->status->value : $tkt->status;
                        $stLower = strtolower($stVal);
                        $badgeBg = '#e2e8f0'; $badgeClr = '#475569';
                        if ($stLower === 'open') { $badgeBg = '#fee2e2'; $badgeClr = '#b91c1c'; }
                        elseif ($stLower === 'proses') { $badgeBg = '#dbeafe'; $badgeClr = '#1d4ed8'; }
                        elseif ($stLower === 'pending') { $badgeBg = '#fef08a'; $badgeClr = '#854d0e'; }
                        elseif ($stLower === 'done') { $badgeBg = '#dcfce3'; $badgeClr = '#166534'; }
                    @endphp
                    <tr style="border-bottom: 1px solid var(--line);">
                        <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                            <div style="font-weight: 700; color: #2563eb; font-size: 0.9rem; font-family: 'JetBrains Mono', monospace;">{{ $tkt->ticket_id }}</div>
                            <div style="font-size: 0.85rem; color: var(--ink); font-weight: 600; margin-top: 2px;">{{ $tkt->pelapor->instansi->nama_instansi ?? 'Koperasi' }}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted);">Pelapor: {{ $tkt->pelapor->nama ?? '-' }}</div>
                        </td>
                        <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                            @if($tkt->picSupport)
                                <div>
                                    <div style="font-weight: 600; font-size: 0.88rem; color: var(--ink);">{{ $tkt->picSupport->nama }}</div>
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: center; vertical-align: middle; font-size: 0.82rem; color: var(--text-muted);">
                            {{ $tkt->updated_at ? $tkt->updated_at->format('d M Y - H:i') : '-' }}
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: center; vertical-align: middle;">
                            <button type="button" onclick="showLogModal('{{ $tkt->ticket_id }}', '{{ addslashes($tkt->pelapor->instansi->nama_instansi ?? 'Koperasi') }}', '{{ addslashes($tkt->picSupport->nama ?? 'Sistem') }}', '{{ $tkt->updated_at ? $tkt->updated_at->format('d M Y H:i') : '' }}', '{{ $stVal }}', '{{ addslashes($tkt->kategori->nama_kategori ?? '-') }}', '{{ addslashes($tkt->penyelesaian ?? '-') }}')" style="background: #2563eb; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            Tidak ada riwayat edit tiket yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--line);">
            {{ $tickets->links() }}
        </div>
    @endif
</div>

</div>

{{-- MODAL DETAIL LOG TIKET --}}
<div id="modalDetailLog" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; backdrop-filter: blur(4px); justify-content: center; align-items: center; padding: 20px;">
    <div style="background: var(--paper-raised); border-radius: 12px; border: 1px solid var(--line); width: 100%; max-width: 520px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--line);">
            <div>
                <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--ink);" id="modalLogTitle">Detail Log Tiket</h4>
                <div style="font-size: 0.8rem; color: var(--text-muted);" id="modalLogSubtitle">Koperasi</div>
            </div>
            <button type="button" onclick="closeLogModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 1.5rem;">
            <div style="background: var(--paper-sunken); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">PETUGAS EDIT PIC</div>
                <div style="font-size: 0.95rem; font-weight: 700; color: #2563eb;" id="modalLogPic">-</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;" id="modalLogTime">-</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div style="background: var(--paper-sunken); border-radius: 8px; padding: 0.85rem;">
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">STATUS HARI INI</div>
                    <div style="font-size: 0.9rem; font-weight: 700; color: var(--ink); margin-top: 2px;" id="modalLogStatus">-</div>
                </div>
                <div style="background: var(--paper-sunken); border-radius: 8px; padding: 0.85rem;">
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">KATEGORI TIKET</div>
                    <div style="font-size: 0.9rem; font-weight: 700; color: var(--ink); margin-top: 2px;" id="modalLogKategori">-</div>
                </div>
            </div>

            <div style="background: var(--paper-sunken); border-radius: 8px; padding: 1rem;">
                <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">SOLUSI / PENYELESAIAN TERAKHIR</div>
                <div style="font-size: 0.88rem; color: var(--ink); line-height: 1.45;" id="modalLogSolusi">-</div>
            </div>
        </div>
        <div style="padding: 1rem 1.5rem; background: var(--paper-sunken); border-top: 1px solid var(--line); text-align: right;">
            <button type="button" onclick="closeLogModal()" style="background: #475569; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');

        setTimeout(function () {
            skeleton.style.display = 'none';
            content.style.display = 'block';
            content.classList.add('loaded');
        }, 350);
    });

    function showLogModal(ticketId, instansi, pic, time, status, kategori, solusi) {
        document.getElementById('modalLogTitle').innerText = 'Detail Log Tiket ' + ticketId;
        document.getElementById('modalLogSubtitle').innerText = instansi;
        document.getElementById('modalLogPic').innerText = pic;
        document.getElementById('modalLogTime').innerText = 'Waktu Update: ' + (time || '-');
        document.getElementById('modalLogStatus').innerText = status;
        document.getElementById('modalLogKategori').innerText = kategori;
        document.getElementById('modalLogSolusi').innerText = solusi || 'Belum ada solusi diinput';

        document.getElementById('modalDetailLog').style.display = 'flex';
    }

    function closeLogModal() {
        document.getElementById('modalDetailLog').style.display = 'none';
    }
</script>
</div>
@endsection
