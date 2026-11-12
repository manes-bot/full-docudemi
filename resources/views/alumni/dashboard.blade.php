@extends('layouts.app')

@section('title', 'Dashboard Alumni - DocuDemi')
@section('page-title', 'Dashboard Alumni')

@push('styles')
<style>
    /* Welcome Hero */
    .welcome-card {
        background: linear-gradient(135deg, #15803D 0%, #166534 100%);
        color: white;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
    }

    .welcome-text h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .welcome-text p {
        font-size: 14px;
        opacity: 0.9;
    }

    /* Grid Summary Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-sizing: border-box;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 22px;
        font-weight: 700;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* Section Video Tutorial Multimedia */
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .video-tutorial-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 32px;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: center;
        box-sizing: border-box;
    }

    .video-thumbnail {
        position: relative;
        width: 100%;
        height: 180px;
        background-color: #172B1C;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.65;
        transition: transform 0.3s ease;
    }

    .video-thumbnail:hover img {
        transform: scale(1.05);
    }

    .play-btn {
        position: absolute;
        width: 56px;
        height: 56px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .video-thumbnail:hover .play-btn {
        transform: scale(1.1);
        background-color: var(--primary-hover);
    }

    .video-info h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .video-info p {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .video-steps {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .step-pill {
        background-color: var(--bg-main);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        color: var(--text-dark);
        font-weight: 500;
        border: 1px solid var(--border-color);
    }

    /* Table Styling */
    .table-container {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container th, .table-container td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
        white-space: nowrap;
    }

    .table-container th {
        background-color: var(--bg-main);
        color: var(--text-muted);
        font-weight: 600;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .welcome-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
        }

        .welcome-card .btn {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px;
        }

        .video-tutorial-card {
            grid-template-columns: 1fr !important;
            padding: 16px;
            gap: 16px;
        }

        .video-thumbnail {
            height: 200px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')

    <!-- Welcome Hero -->
    <div class="welcome-card">
        <div class="welcome-text">
            <h2>Selamat Datang, {{ $alumni->nama ?? Auth::user()->name }}! 👋</h2>
            <p>Ajukan permohonan legalisir dan pengambilan Ijazah sekolah dengan cepat dan mudah melalui sistem DocuDemi.</p>
        </div>
        <a href="{{ route('alumni.pengajuan.create') }}" class="btn" style="background-color: white; color: var(--primary); font-weight: 600;">
            <i data-lucide="plus"></i> Ajukan Layanan
        </a>
    </div>

    <!-- Summary Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #E0F2FE; color: #0284C7;">
                <i data-lucide="file-text"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalPengajuan }}</div>
                <div class="stat-label">Total Permohonan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #FEF3C7; color: #D97706;">
                <i data-lucide="clock"></i>
            </div>
            <div>
                <div class="stat-number">{{ $sedangDiproses }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #DCFCE7; color: #15803D;">
                <i data-lucide="check-circle"></i>
            </div>
            <div>
                <div class="stat-number">{{ $siapDiambil }}</div>
                <div class="stat-label">Siap Diambil</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #F1F5F9; color: #475569;">
                <i data-lucide="archive"></i>
            </div>
            <div>
                <div class="stat-number">{{ $selesai }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <!-- Fitur Video Tutorial Multimedia -->
    <div class="section-title">
        <i data-lucide="video" style="color: var(--primary);"></i> Panduan Video Tutorial
    </div>

    <div class="video-tutorial-card">
        <!-- Sesuaikan path asset dengan struktur folder kamu di screenshot (video/turorial.mp4) -->
        <div class="video-thumbnail" onclick="openVideoModal('{{ asset('video/turorial.mp4') }}')">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop" alt="Thumbnail Tutorial">
            <div class="play-btn">
                <i data-lucide="play" style="margin-left: 4px;"></i>
            </div>
        </div>
        <div class="video-info">
            <h3>Cara Mudah Mengajukan Dokumen Akademik</h3>
            <p>Tonton panduan singkat ini untuk memahami alur pemilihan layanan legalisir/pengambilan Ijazah, penentuan tanggal pengambilan, serta cara melacak status permohonan Anda hingga siap diambil di kurikulum.</p>
            <div class="video-steps">
                <span class="step-pill">1. Pilih Layanan</span>
                <span class="step-pill">2. Isi Keperluan</span>
                <span class="step-pill">3. Tentukan Jadwal</span>
                <span class="step-pill">4. Pantau Status Tracking</span>
            </div>
        </div>
    </div>

    <!-- Table Pengajuan Terbaru -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div class="section-title" style="margin-bottom: 0;">Pengajuan Terbaru</div>
            <a href="{{ route('alumni.pengajuan.index') }}" style="color: var(--primary); font-size: 14px; font-weight: 600; text-decoration: none;">Lihat Semua →</a>
        </div>

        @if($pengajuanTerbaru->isEmpty())
            <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 12px; stroke-width: 1.5;"></i>
                <p>Belum ada pengajuan layanan yang dibuat.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Jenis Layanan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Rencana Pengambilan</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuanTerbaru as $item)
                            <tr>
                                <td style="font-weight: 600;">{{ $item->jenis_layanan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if($item->status == 'Menunggu Pemeriksaan')
                                        <span class="badge badge-warning">Menunggu Pemeriksaan</span>
                                    @elseif(in_array($item->status, ['Sedang Diproses', 'Disiapkan']))
                                        <span class="badge badge-info">{{ $item->status }}</span>
                                    @elseif(in_array($item->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('alumni.pengajuan.show', $item->id) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal Video Player (Lokal HTML5 Video) -->
    <div id="localVideoModal" class="modal-overlay" onclick="closeVideoModal(event)">
        <div class="modal-dialog" onclick="event.stopPropagation()">
            <div class="modal-head" style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h3 style="color: white; font-size: 16px; margin: 0; font-weight: 600;">Panduan Penggunaan DocuDemi</h3>
                <button type="button" class="modal-close" onclick="closeVideoModal()">&times;</button>
            </div>
            <div style="padding: 16px;">
                <video id="videoPlayer" controls style="width: 100%; border-radius: 10px; background: #000; outline: none;">
                    <source id="videoSource" src="" type="video/mp4">
                    Browser Anda tidak mendukung pemutaran video ini.
                </video>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openVideoModal(videoUrl) {
        var modal = document.getElementById('localVideoModal');
        var player = document.getElementById('videoPlayer');
        var source = document.getElementById('videoSource');

        if (modal && player && source) {
            source.src = videoUrl;
            player.load();
            modal.style.display = 'flex';
            modal.classList.add('is-open');
            player.play();
        }
    }

    function closeVideoModal(event) {
        if (!event || event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal-close')) {
            var modal = document.getElementById('localVideoModal');
            var player = document.getElementById('videoPlayer');

            if (modal && player) {
                player.pause();
                player.currentTime = 0;
                modal.style.display = 'none';
                modal.classList.remove('is-open');
            }
        }
    }
</script>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush