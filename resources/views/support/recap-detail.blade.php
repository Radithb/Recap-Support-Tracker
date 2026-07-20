@extends('layouts.app')

@section('page_title', 'Laporan Detail Support')
@section('page_subtitle', 'internal.ptskk.id')

@section('content')
<div class="pelapor-panel">
    {{-- SKELETON LOADING STATE --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel-panel" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 2rem; margin-bottom: 2rem; max-width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <div>
                    <div class="skel" style="width: 250px; height: 28px; border-radius: 6px; margin-bottom: 12px;"></div>
                    <div class="skel" style="width: 450px; height: 14px; border-radius: 4px;"></div>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <div class="skel" style="width: 100px; height: 32px; border-radius: 20px;"></div>
                    <div class="skel" style="width: 100px; height: 32px; border-radius: 20px;"></div>
                    <div class="skel" style="width: 120px; height: 32px; border-radius: 20px;"></div>
                </div>
            </div>
            
            <div class="skel" style="width: 100%; height: 400px; border-radius: 8px; margin-bottom: 1.5rem;"></div>
            
            <div>
                <div class="skel" style="width: 180px; height: 32px; border-radius: 6px;"></div>
            </div>
        </div>
    </div>

    {{-- ACTUAL CONTENT --}}
    <div class="content-wrap" id="actual-content" style="display: none;">
        <div class="glass-panel fade-up" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 2rem; margin-bottom: 2rem; animation-delay: 0.1s;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; color: var(--ink);">Laporan Detail Support {{ $monthName }} {{ $year }}</h3>
                <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Rincian per tiket — sumber data untuk kedua rekap di atas (Kategori & PIC). Kolom sama seperti file Excel Tim Support.</p>
            </div>
            
            <div style="display: flex; gap: 1rem; align-items: center;">
                <form action="{{ route('support.recap.detail') }}" method="GET" id="filterForm" style="display: flex; gap: 0.5rem; margin: 0;">
                    <select name="month" onchange="document.getElementById('filterForm').submit()" style="padding: 6px 12px; border-radius: 20px; border: 1px solid var(--line); font-family: var(--font-body); font-weight: 500; font-size: 0.85rem; color: var(--ink); background: var(--paper-raised); cursor: pointer; outline:none;">
                        @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $m => $mName)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $mName }}</option>
                        @endforeach
                    </select>
                    <select name="year" onchange="document.getElementById('filterForm').submit()" style="padding: 6px 12px; border-radius: 20px; border: 1px solid var(--line); font-family: var(--font-body); font-weight: 500; font-size: 0.85rem; color: var(--ink); background: var(--paper-raised); cursor: pointer; outline:none;">
                        @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
                
                <div style="background: #1e3a8a; color: white; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; white-space: nowrap;">
                    Jumlah Data: {{ count($tickets) }}
                </div>
            </div>
        </div>

        <div style="overflow-x: auto; border: 1px solid var(--line); border-radius: 8px;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1500px; font-size: 0.85rem;">
                <thead>
                    <tr style="background: #1e3a8a; color: white;">
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; text-transform: uppercase;">NO</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">NAMA KOPERASI</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">PIC KOPERASI</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">TANGGAL</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">PERMASALAHAN</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">PENYELESAIAN</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">PENCEGAHAN</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">TANGGAL</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; text-transform: uppercase;">KATEGORI</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">PIC</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; text-transform: uppercase;">FAQ</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; text-transform: uppercase;">STATUS CASE</th>
                        <th style="padding: 12px 16px; text-align: left; font-weight: 600; text-transform: uppercase;">LINK TICKET</th>
                        <th style="padding: 12px 16px; text-align: center; font-weight: 600; text-transform: uppercase;">KET</th>
                    </tr>
                </thead>
                <tbody style="background: var(--paper-raised);">
                    @forelse($tickets as $index => $t)
                    <tr style="border-bottom: 1px solid var(--line);">
                        <td style="padding: 12px 16px; text-align: center; color: var(--text-muted);">{{ $index + 1 }}</td>
                        <td style="padding: 12px 16px; color: var(--ink); font-weight: 500;">{{ $t->pelapor->instansi->nama_instansi ?? ($t->pelapor->nama ?? '-') }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted);">{{ $t->pelapor->nama ?? '-' }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted);">{{ $t->tanggal_input ? $t->tanggal_input->format('d-m-Y') : '-' }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted); max-width: 250px;">{{ $t->permasalahan ?? '-' }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted); max-width: 250px;">{{ $t->penyelesaian ?? '-' }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted); max-width: 200px;">{{ $t->pencegahan ?? '-' }}</td>
                        <td style="padding: 12px 16px; color: var(--text-muted);">{{ $t->tanggal_penyelesaian ? $t->tanggal_penyelesaian->format('d-m-Y') : '-' }}</td>
                        
                        <td style="padding: 12px 16px; text-align: center;">
                            @if($t->kategori)
                                <span style="background: rgba(217, 119, 108, 0.15); color: #c0564a; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; display: inline-block;">
                                    {{ $t->kategori->nama_kategori }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td style="padding: 12px 16px; white-space: nowrap;">
                            @if($t->picSupport)
                                @php
                                    $words = explode(' ', $t->picSupport->nama);
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                                @endphp
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                                        {{ $initials }}
                                    </div>
                                    <span style="color: var(--text-muted);">{{ $t->picSupport->nama }}</span>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td style="padding: 12px 16px; text-align: center; color: var(--text-muted);">
                            {{ $t->is_faq ? 'TRUE' : 'FALSE' }}
                        </td>
                        
                        <td style="padding: 12px 16px; text-align: center;">
                            @php
                                $statusVal = $t->status->value ?? $t->status;
                                $statusLower = strtolower($statusVal);
                                
                                if ($statusLower === 'done') {
                                    $bg = '#dcfce7'; $color = '#16a34a'; // Hijau
                                } elseif ($statusLower === 'pending') {
                                    $bg = '#fef9c3'; $color = '#ca8a04'; // Kuning
                                } elseif ($statusLower === 'proses' || $statusLower === 'on progress' || $statusLower === 'open') {
                                    $bg = '#fee2e2'; $color = '#dc2626'; // Merah
                                } else {
                                    $bg = 'var(--paper-sunken)'; $color = 'var(--text-muted)'; // Default abu-abu
                                }
                            @endphp
                            <span style="background: {{ $bg }}; color: {{ $color }}; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $color }};"></span> {{ $statusVal }}
                            </span>
                        </td>
                        
                        <td style="padding: 12px 16px;">
                            @if($t->link_ticket)
                                <a href="{{ $t->link_ticket }}" target="_blank" style="color: #3b82f6; text-decoration: none;">{{ $t->link_ticket }}</a>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        
                        <td style="padding: 12px 16px; text-align: center; color: var(--text-muted);">-</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="14" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            Belum ada data tiket pada bulan dan tahun terpilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('support.recap') }}" class="btn btn-ghost" style="padding: 8px 16px; font-size: 0.85rem;">&larr; Kembali ke Rekap Support</a>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const skeleton = document.getElementById('skeleton-loading');
            const content  = document.getElementById('actual-content');
            if(skeleton && content) {
                setTimeout(function () {
                    skeleton.style.display = 'none';
                    content.style.display = 'block';
                    content.classList.add('loaded');
                }, 800);
            }
        });
    </script>
</div>
@endsection
