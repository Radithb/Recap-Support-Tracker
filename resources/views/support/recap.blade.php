@extends('layouts.app')

@section('content')

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

<div class="glass-panel fade-up" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; animation-delay: 0.1s;">
    <div>
        <h2>Analytics & Reporting (FR-10)</h2>
        <p>Rekapitulasi tiket berdasarkan bulan & kategori.</p>
    </div>
    <form method="GET">
        <select name="year" onchange="this.form.submit()" style="width: 150px; font-weight: bold; padding: 0.5rem;">
            @for($y = date('Y'); $y >= 2023; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
            @endfor
        </select>
    </form>
</div>

<div class="grid-2">
    <!-- FR-10A: Bar Chart -->
    <div class="glass-panel fade-up" style="animation-delay: 0.2s;">
        <h3>Tiket Masuk per Bulan ({{ $year }})</h3>
        <canvas id="monthlyChart"></canvas>
    </div>

    <!-- FR-10B: Crosstab Table -->
    <div class="glass-panel fade-up" style="overflow-x: auto; animation-delay: 0.3s;">
        <h3>Sebaran Kategori (Done) ({{ $year }})</h3>
        <table style="font-size: 0.85rem;">
            <thead>
                <tr>
                    <th>Kategori</th>
                    @for($m = 1; $m <= 12; $m++)
                        <th style="text-align: center;">{{ date('M', mktime(0,0,0,$m,1)) }}</th>
                    @endfor
                    <th style="text-align: center; color: var(--primary);">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($crosstab as $catData)
                    <tr>
                        <td><strong>{{ $catData['nama'] }}</strong></td>
                        @for($m = 1; $m <= 12; $m++)
                            <td style="text-align: center; {{ $catData['months'][$m] > 0 ? 'color: var(--success); font-weight: bold;' : 'color: var(--text-muted);' }}">
                                {{ $catData['months'][$m] }}
                            </td>
                        @endfor
                        <td style="text-align: center; font-weight: bold; color: var(--primary);">
                            {{ $catData['total_year'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Jumlah Tiket',
                        data: @json($chartData),
                        backgroundColor: 'rgba(30, 59, 142, 0.5)',
                        borderColor: 'rgba(30, 59, 142, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { labels: { color: '#94a3b8' } }
                    }
                }
            });
        }, 1200);
    });
</script>
@endsection
