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

    <div class="skel-recap-grid">
        <div class="skel-recap-chart">
            <div class="skel skel-chart-title"></div>
            <div class="skel skel-chart-area"></div>
        </div>
        <div class="skel-recap-chart">
            <div class="skel skel-chart-title"></div>
            <div class="skel skel-chart-area"></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ACTUAL CONTENT                              --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="content-wrap" id="actual-content">

@section('page_title', 'Rekap Support')
@section('page_subtitle', 'internal.ptskk.id')

<div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom: 2.5rem;">
    <div>
        <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600;">REKAP SUPPORT &bull; {{ strtoupper(Auth::user()->nama ?? 'ANDRA W.') }}</p>
        <h1 style="margin: 0; font-size: 2rem; color: var(--ink);">Rekapan Tiket Tahunan</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem; max-width: 600px; line-height: 1.5;">Rekap otomatis dari seluruh tiket yang dilaporkan Pelapor &amp; dikategorikan Tim Support &mdash; bisa ganti tahun kapan saja.</p>
    </div>
</div>

<div class="glass-panel fade-up" style="animation-delay: 0.15s; background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div>
            <h3 style="margin: 0; font-size: 1.25rem; color: var(--ink);">Rekap Tiket Bulanan</h3>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">FR-10 Reporting Analytics &mdash; klik salah satu bulan untuk lihat detail, atau ganti tahun di sebelah kanan</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                <a href="{{ route('support.recap', ['year' => $y]) }}" class="btn {{ $year == $y ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; border: 1px solid {{ $year == $y ? 'transparent' : 'var(--line)' }}; {{ $year == $y ? 'background: var(--ink); color: #fff;' : 'background: transparent; color: var(--ink);' }}">{{ $y }}</a>
            @endfor
        </div>
    </div>

    <div style="height: 250px; margin-bottom: 2rem;">
        <canvas id="monthlyChart"></canvas>
    </div>

    @php
        $totalTickets = array_sum($chartData);
    @endphp
    <div style="background: #f1f5f9; border-radius: 8px; padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">
        Menampilkan rekap tahun <strong>{{ $year }}</strong> &mdash; total <strong>{{ $totalTickets }}</strong> tiket dari Januari&ndash;Desember.
    </div>


</div>

<div class="glass-panel fade-up" style="animation-delay: 0.2s; background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
        <div>
            <h3 style="margin: 0; font-size: 1.1rem; color: var(--ink);">Rekap Support {{ $year }}</h3>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Terekap otomatis dari tiket yang dilaporkan Pelapor &amp; dikategorikan Tim Support saat penyelesaian (kategori_id, FR-07)</p>
        </div>
        <span class="badge" style="background: var(--ink); color: #fff; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $year }}</span>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead style="background: #f1f5f9;">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Kategori</th>
                    @php $months = ['JAN','FEB','MAR','APR','MAY','JUNE','JULY','AUG','SEPT','OCT','NOV','DEC']; @endphp
                    @foreach($months as $m)
                        <th style="padding: 1rem 0.5rem; text-align: center; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 1px;">{{ $m }}</th>
                    @endforeach
                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; color: var(--ink); font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Total Keseluruhan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $colTotals = array_fill(1, 12, 0);
                    $grandTotal = 0;
                @endphp
                @foreach($crosstab as $catData)
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 1rem 1.5rem; color: var(--ink); font-size: 0.9rem;">{{ $catData['nama'] }}</td>
                    @for($m = 1; $m <= 12; $m++)
                        @php $colTotals[$m] += $catData['months'][$m]; @endphp
                        <td style="padding: 1rem 0.5rem; text-align: center; color: var(--ink); font-size: 0.9rem;">
                            {{ $catData['months'][$m] > 0 ? $catData['months'][$m] : '-' }}
                        </td>
                    @endfor
                    <td style="padding: 1rem 1.5rem; text-align: center; font-weight: 700; color: var(--ink); font-size: 0.9rem; background: #f8fafc;">
                        {{ $catData['total_year'] }}
                        @php $grandTotal += $catData['total_year']; @endphp
                    </td>
                </tr>
                @endforeach
                
                {{-- Total Row --}}
                <tr style="background: #1e40af; color: #fff;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; font-size: 0.9rem;">Total</td>
                    @for($m = 1; $m <= 12; $m++)
                        <td style="padding: 1rem 0.5rem; text-align: center; font-weight: 600; font-size: 0.9rem;">
                            {{ $colTotals[$m] > 0 ? $colTotals[$m] : '0' }}
                        </td>
                    @endfor
                    <td style="padding: 1rem 1.5rem; text-align: center; font-weight: 700; font-size: 0.9rem; background: #1e3a8a;">
                        {{ $grandTotal }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.85rem;">
        Total keseluruhan <strong>{{ $grandTotal }}</strong> tiket &mdash; dihitung otomatis, ikut ter-update begitu Tim Support menyimpan kategori tiket baru dari laporan Pelapor.
    </div>
</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');

        setTimeout(function () {
            skeleton.style.display = 'none';
            content.classList.add('loaded');

            // Render chart after content is visible
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'],
                    datasets: [{
                        label: 'Jumlah Tiket',
                        data: @json($chartData),
                        backgroundColor: '#e2e8f0',
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { display: false, beginAtZero: true },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' },
                            border: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            cornerRadius: 6,
                            displayColors: false
                        }
                    }
                }
            });
        }, 1200);
    });
</script>
</div>
@endsection
