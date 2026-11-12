@extends('layouts.app')

@section('title', 'Dashboard Petugas - DocuDemi')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #15803D 0%, #166534 100%);
        color: white;
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        width: 100%;
    }

    .welcome-text h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
    .welcome-text p { font-size: 13px; opacity: 0.9; }

    .quick-actions { display: flex; gap: 12px; }
    .btn-quick {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-quick:hover { background: rgba(255, 255, 255, 0.25); }

    /* 5 Stat Cards Grid */
    .stats-5-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .stat-card-figma {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 18px;
        box-sizing: border-box;
    }
    .stat-card-figma .num { font-size: 24px; font-weight: 800; color: #15803D; margin-top: 8px; }
    .stat-card-figma .title { font-size: 13px; font-weight: 700; color: var(--text-dark); margin-top: 2px; }
    .stat-card-figma .sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

    /* Main Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .table-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        box-sizing: border-box;
        width: 100%;
        overflow: hidden; /* Kunci batas card biar gak beleber */
    }

    /* Container scroll horizontal khusus tabel */
    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        display: block;
    }

    .table-figma { 
        width: 100%; 
        min-width: 540px; /* Jaga lebar minimal tabel biar tidak penyet */
        border-collapse: collapse; 
    }
    .table-figma th { font-size: 11px; text-transform: uppercase; color: var(--text-muted); padding: 12px 14px; text-align: left; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
    .table-figma td { font-size: 13px; padding: 14px; border-bottom: 1px solid var(--border-color); vertical-align: middle; white-space: nowrap; }

    /* Widgets */
    .widget-box {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        box-sizing: border-box;
        width: 100%;
    }

    .widget-box.green-box {
        background: #F0FDF4;
        border-color: #BBF7D0;
    }

    .widget-title { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    
    .widget-item { 
        background: white; 
        border-radius: 8px; 
        padding: 12px; 
        margin-bottom: 10px; 
        border: 1px solid rgba(0,0,0,0.05); 
        box-sizing: border-box;
        width: 100%;
    }

    .btn-verify {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 10px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        color: white;
        background-color: #D97706;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        box-sizing: border-box;
    }

    /* Responsive Mobile adjustments (< 768px) */
    @media (max-width: 767px) {
        .welcome-banner {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
        }

        .quick-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn-quick {
            justify-content: center;
            width: 100%;
        }

        .stats-5-grid {
            grid-template-columns: 1fr !important;
            gap: 12px;
        }

        .dashboard-grid {
            grid-template-columns: 1fr !important;
            gap: 16px;
        }

        .table-card {
            padding: 16px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')

    <!-- Welcome Banner Dinamis -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <p style="font-size: 12px; opacity: 0.8;">Selamat datang,</p>
            <h2>{{ $user->name }}</h2>
            <p>Petugas Kurikulum · {{ $user->email }}</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('petugas.pengajuan.index') }}" class="btn-quick">
                <i data-lucide="inbox" style="width: 16px;"></i> Pengajuan Masuk
            </a>
            <a href="{{ route('petugas.arsip') }}" class="btn-quick">
                <i data-lucide="archive" style="width: 16px;"></i> Arsip Dokumen
            </a>
            <a href="{{ route('petugas.jadwal') }}" class="btn-quick">
                <i data-lucide="calendar" style="width: 16px;"></i> Atur Jadwal
            </a>
        </div>
    </div>

    <!-- 5 Stat Cards Dinamis -->
    <div class="stats-5-grid">
        <div class="stat-card-figma">
            <i data-lucide="inbox" style="color: #D97706; width: 20px;"></i>
            <div class="num">{{ $pengajuanBaru }}</div>
            <div class="title">Pengajuan Baru</div>
            <div class="sub">2 hari terakhir</div>
        </div>

        <div class="stat-card-figma">
            <i data-lucide="hourglass" style="color: #D97706; width: 20px;"></i>
            <div class="num">{{ $perluPemeriksaan }}</div>
            <div class="title">Menunggu Pemeriksaan</div>
            <div class="sub">Perlu tindakan</div>
        </div>

        <div class="stat-card-figma">
            <i data-lucide="settings" style="color: #2563EB; width: 20px;"></i>
            <div class="num">{{ $sedangDiproses }}</div>
            <div class="title">Sedang Diproses</div>
            <div class="sub">Aktif</div>
        </div>

        <div class="stat-card-figma">
            <i data-lucide="check-square" style="color: #16A34A; width: 20px;"></i>
            <div class="num">{{ $siapDiambil }}</div>
            <div class="title">Siap Diambil</div>
            <div class="sub">Menunggu alumni</div>
        </div>

        <div class="stat-card-figma">
            <i data-lucide="party-popper" style="color: #9333EA; width: 20px;"></i>
            <div class="num">{{ $selesaiBulanIni }}</div>
            <div class="title">Selesai Bulan Ini</div>
            <div class="sub">Total bulan ini</div>
        </div>
    </div>

    <!-- Grid Layout Utama -->
    <div class="dashboard-grid">
        <!-- Table Pengajuan Terbaru Dinamis -->
        <div class="table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 16px; font-weight: 700;">Pengajuan Terbaru</h3>
                <a href="{{ route('petugas.pengajuan.index') }}" style="color: #15803D; font-size: 13px; font-weight: 600; text-decoration: none;">Lihat Semua →</a>
            </div>

            @if($pengajuanTerbaru->isEmpty())
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    Belum ada data pengajuan dari alumni.
                </div>
            @else
                <!-- Scroll Wrapper Terisolasi -->
                <div class="table-scroll-wrapper">
                    <table class="table-figma">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAMA ALUMNI</th>
                                <th>LAYANAN</th>
                                <th>STATUS</th>
                                <th style="text-align: right;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuanTerbaru as $item)
                                <tr>
                                    <td style="font-weight: 700; color: #15803D;">
                                        #DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td style="font-weight: 600;">{{ $item->alumni->nama ?? '-' }}</td>
                                    <td>{{ $item->jenis_layanan }}</td>
                                    <td>
                                        @if($item->status == 'Menunggu Pemeriksaan')
                                            <span class="badge badge-warning">● Menunggu Pemeriksaan</span>
                                        @elseif(in_array($item->status, ['Sedang Diproses', 'Disiapkan']))
                                            <span class="badge badge-info">● {{ $item->status }}</span>
                                        @elseif(in_array($item->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                                            <span class="badge badge-success">● {{ $item->status }}</span>
                                        @else
                                            <span class="badge badge-danger">● Ditolak</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('petugas.pengajuan.show', $item->id) }}" style="color: #15803D; font-weight: 600; font-size: 12px; text-decoration: none;">Proses</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Right Dynamic Widgets -->
        <div>
            <!-- Widget Perlu Tindakan Dinamis -->
            <div class="widget-box">
                <div class="widget-title" style="color: #D97706;">
                    <i data-lucide="alert-triangle" style="width: 18px;"></i> Perlu Tindakan
                </div>

                @forelse($perluTindakan as $item)
                    <div class="widget-item">
                        <div style="font-size: 11px; font-weight: 700; color: #15803D;">
                            #DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="font-size: 13px; font-weight: 700; margin-top: 2px;">{{ $item->alumni->nama ?? '-' }}</div>
                        <div style="font-size: 11px; color: var(--text-muted);">{{ $item->jenis_layanan }}</div>
                        <a href="{{ route('petugas.pengajuan.show', $item->id) }}" class="btn-verify">Verifikasi</a>
                    </div>
                @empty
                    <div style="font-size: 12px; color: var(--text-muted); text-align: center; padding: 10px;">
                        Tidak ada pengajuan menunggu.
                    </div>
                @endforelse
            </div>

            <!-- Widget Siap Diambil Dinamis -->
            <div class="widget-box green-box">
                <div class="widget-title" style="color: #16A34A;">
                    <i data-lucide="check-circle" style="width: 18px;"></i> Siap Diambil
                </div>

                @forelse($siapDiambilList as $item)
                    <div class="widget-item">
                        <div style="font-size: 11px; font-weight: 700; color: #15803D;">
                            #DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="font-size: 13px; font-weight: 700; margin-top: 2px;">{{ $item->alumni->nama ?? '-' }}</div>
                        <div style="font-size: 11px; color: var(--text-muted);">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                @empty
                    <div style="font-size: 12px; color: var(--text-muted); text-align: center; padding: 10px;">
                        Belum ada dokumen siap diambil.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush