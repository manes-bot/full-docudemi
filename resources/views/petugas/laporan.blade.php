@extends('layouts.app')

@section('title', 'Laporan & Statistik - DocuDemi')
@section('page-title', 'Laporan')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Report Header */
    .report-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 24px; 
    }
    .report-header h2 { font-size: 22px; font-weight: 700; color: var(--text-dark); margin-bottom: 2px; }
    .report-header p { font-size: 13px; color: var(--text-muted); }
    .report-actions { display: flex; gap: 10px; }

    /* 6 Stat Cards Grid */
    .stats-6-grid { 
        display: grid; 
        grid-template-columns: repeat(6, 1fr); 
        gap: 16px; 
        margin-bottom: 24px; 
    }
    .stat-mini-card { 
        background: white; 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        padding: 16px; 
        position: relative; 
        box-sizing: border-box;
    }
    .stat-mini-card .icon-box { position: absolute; top: 16px; left: 16px; }
    .stat-mini-card .stat-num { font-size: 26px; font-weight: 800; text-align: right; line-height: 1; }
    .stat-mini-card .stat-title { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-top: 12px; }

    /* Charts Grid */
    .charts-grid { 
        display: grid; 
        grid-template-columns: 3fr 2fr; 
        gap: 20px; 
        margin-bottom: 24px; 
    }
    .chart-card { 
        background: white; 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        padding: 20px; 
        box-sizing: border-box;
        overflow: hidden;
    }
    .chart-card h3 { font-size: 15px; font-weight: 700; color: var(--text-dark); margin-bottom: 16px; }
    
    /* Pengunci canvas Chart.js biar tidak meluber di HP */
    .chart-container { 
        position: relative; 
        height: 240px; 
        width: 100%; 
        max-width: 100%;
    }

    /* Rincian per Layanan */
    .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .service-detail-card { background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; box-sizing: border-box; }
    .service-detail-card h4 { font-size: 15px; font-weight: 700; margin-bottom: 16px; }
    .service-detail-stats { display: grid; grid-template-columns: repeat(3, 1fr); text-align: center; gap: 12px; }
    .detail-stat-box { background: var(--bg-main); padding: 12px; border-radius: 8px; }
    .detail-stat-box .val { font-size: 18px; font-weight: 700; }
    .detail-stat-box .lbl { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

    /* RESPONSIVE MEDIA QUERIES (BREAKPOINT MOBILE < 768px) */
    @media (max-width: 1024px) {
        .stats-6-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 767px) {
        .report-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .report-actions {
            width: 100%;
            flex-direction: column;
        }

        .report-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .stats-6-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px;
        }

        .charts-grid {
            grid-template-columns: 1fr !important;
            gap: 16px;
        }

        .chart-card {
            padding: 16px;
        }

        .chart-container {
            height: 220px; /* Ukuran proporsional di layar HP */
        }

        .details-grid {
            grid-template-columns: 1fr !important;
            gap: 16px;
        }

        .service-detail-stats {
            gap: 8px;
        }

        .detail-stat-box {
            padding: 8px;
        }
    }

    @media (max-width: 480px) {
        .stats-6-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')
    <div class="report-header">
        <div>
            <h2>Laporan</h2>
            <p>Statistik pengajuan dokumen akademik real-time dari database.</p>
        </div>
        <div class="report-actions">
            <a href="{{ route('petugas.laporan.export') }}" class="btn btn-outline">
                <i data-lucide="download" style="width: 16px;"></i> Export Excel
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i data-lucide="printer" style="width: 16px;"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- 6 Stat Cards Dinamis -->
    <div class="stats-6-grid">
        <div class="stat-mini-card">
            <div class="icon-box"><i data-lucide="clipboard-list" style="color: #64748B;"></i></div>
            <div class="stat-num" style="color: #0F172A;">{{ $totalPengajuan }}</div>
            <div class="stat-title">Total Pengajuan</div>
        </div>
        <div class="stat-mini-card" style="background: #EFF6FF; border-color: #BFDBFE;">
            <div class="icon-box"><i data-lucide="file-text" style="color: #2563EB;"></i></div>
            <div class="stat-num" style="color: #2563EB;">{{ $totalLegalisir }}</div>
            <div class="stat-title" style="color: #1E40AF;">Legalisir</div>
        </div>
        <div class="stat-mini-card" style="background: #FAF5FF; border-color: #E9D5FF;">
            <div class="icon-box"><i data-lucide="book-open" style="color: #9333EA;"></i></div>
            <div class="stat-num" style="color: #9333EA;">{{ $totalRapor }}</div>
            <div class="stat-title" style="color: #6B21A8;">Pengambilan Ijazzah</div>
        </div>
        <div class="stat-mini-card" style="background: #F0FDF4; border-color: #BBF7D0;">
            <div class="icon-box"><i data-lucide="check-square" style="color: #16A34A;"></i></div>
            <div class="stat-num" style="color: #16A34A;">{{ $totalSelesai }}</div>
            <div class="stat-title" style="color: #166534;">Selesai</div>
        </div>
        <div class="stat-mini-card" style="background: #FEF2F2; border-color: #FECACA;">
            <div class="icon-box"><i data-lucide="x-circle" style="color: #DC2626;"></i></div>
            <div class="stat-num" style="color: #DC2626;">{{ $totalDitolak }}</div>
            <div class="stat-title" style="color: #991B1B;">Ditolak</div>
        </div>
        <div class="stat-mini-card" style="background: #FFFBEB; border-color: #FDE68A;">
            <div class="icon-box"><i data-lucide="settings" style="color: #D97706;"></i></div>
            <div class="stat-num" style="color: #D97706;">{{ $totalDiproses }}</div>
            <div class="stat-title" style="color: #92400E;">Diproses</div>
        </div>
    </div>

    <!-- Charts Grid Dinamis -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3>Pengajuan per Bulan</h3>
            <div class="chart-container">
                <canvas id="barChartBulan"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>Distribusi Status</h3>
            <div class="chart-container" style="display: flex; justify-content: center; align-items: center;">
                <canvas id="donutChartStatus"></canvas>
            </div>
        </div>
    </div>

    <!-- Rincian per Layanan -->
    <div class="card" style="padding: 20px;">
        <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 16px;">Rincian per Layanan</h3>
        <div class="details-grid">
            <div class="service-detail-card">
                <h4>Legalisir</h4>
                <div class="service-detail-stats">
                    <div class="detail-stat-box"><div class="val" style="color: #2563EB;">{{ $totalLegalisir }}</div><div class="lbl">Total</div></div>
                    <div class="detail-stat-box"><div class="val" style="color: #16A34A;">{{ $legalisirSelesai }}</div><div class="lbl">Selesai</div></div>
                    <div class="detail-stat-box"><div class="val" style="color: #D97706;">{{ $legalisirProses }}</div><div class="lbl">Proses</div></div>
                </div>
            </div>
            <div class="service-detail-card">
                <h4>Pengambilan Ijazah</h4>
                <div class="service-detail-stats">
                    <div class="detail-stat-box"><div class="val" style="color: #9333EA;">{{ $totalRapor }}</div><div class="lbl">Total</div></div>
                    <div class="detail-stat-box"><div class="val" style="color: #16A34A;">{{ $raporSelesai }}</div><div class="lbl">Selesai</div></div>
                    <div class="detail-stat-box"><div class="val" style="color: #D97706;">{{ $raporProses }}</div><div class="lbl">Proses</div></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const monthLabels = @json($months);
        const legalisirData = @json($legalisirMonthly);
        const raporData = @json($raporMonthly);
        const donutValues = @json($donutData);

        const isMobile = window.innerWidth < 768;

        const ctxBar = document.getElementById('barChartBulan').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                    { label: 'Legalisir', data: legalisirData, backgroundColor: '#3B82F6', borderRadius: 4 },
                    { label: 'Peminjaman Rapor', data: raporData, backgroundColor: '#22C55E', borderRadius: 4 }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                scales: { 
                    x: { stacked: true, grid: { display: false } }, 
                    y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } } 
                }, 
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { boxWidth: 12, padding: 10, font: { size: 11 } } 
                    } 
                } 
            }
        });

        const ctxDonut = document.getElementById('donutChartStatus').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Diproses', 'Ditolak'],
                datasets: [{ 
                    data: [donutValues.selesai, donutValues.diproses, donutValues.ditolak], 
                    backgroundColor: ['#22C55E', '#3B82F6', '#EF4444'], 
                    borderWidth: 2, 
                    borderColor: '#ffffff' 
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                cutout: '70%', 
                plugins: { 
                    legend: { 
                        position: isMobile ? 'bottom' : 'right', // Di HP legenda otomatis pindah ke bawah agar doughnut tidak penyet
                        labels: { boxWidth: 12, padding: 10, font: { size: 11 } } 
                    } 
                } 
            }
        });
    });
</script>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush