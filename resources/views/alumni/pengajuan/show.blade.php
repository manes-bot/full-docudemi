@extends('layouts.app')

@section('title', 'Detail Tracking Pengajuan - DocuDemi')
@section('page-title', 'Detail Tracking Status')

@push('styles')
<style>
    .tracking-container {
        max-width: 860px;
        margin: 0 auto;
    }

    /* Stepper Status Visual */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin: 32px 0 40px 0;
        position: relative;
    }

    .stepper-wrapper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 30px;
        right: 30px;
        height: 3px;
        background-color: var(--border-color);
        z-index: 1;
    }

    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .step-counter {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: var(--surface);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }

    .step-item.active .step-counter {
        border-color: var(--primary);
        background-color: var(--primary);
        color: white;
    }

    .step-item.completed .step-counter {
        border-color: var(--secondary);
        background-color: var(--secondary);
        color: white;
    }

    .step-name {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-align: center;
    }

    .step-item.active .step-name {
        color: var(--primary);
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 24px;
    }

    .detail-item {
        background-color: var(--bg-main);
        padding: 16px;
        border-radius: 8px;
    }

    .detail-label {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .rejection-box {
        background-color: #FEE2E2;
        border: 1px solid #FCA5A5;
        border-radius: 10px;
        padding: 20px;
        margin-top: 24px;
    }

    .rejection-box h4 {
        color: #991B1B;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rejection-box p {
        color: #B91C1C;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Box Download Hasil Balasan */
    .download-card {
        background-color: #F0FDF4;
        border: 1px solid #BBF7D0;
        padding: 20px;
        border-radius: 12px;
        margin-top: 24px;
    }

    .download-card-title {
        color: #166534;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }
</style>
@endpush

@section('content')
<div class="tracking-container">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('alumni.pengajuan.index') }}" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">
            <i data-lucide="arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>
    </div>

    <div class="card no-lift" style="padding: 24px;">
        <div class="card-head" style="border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
            <div>
                <span style="font-size: 12px; color: var(--text-muted);">ID Pengajuan: #DOC-{{ str_pad($pengajuan->id, 5, '0', STR_PAD_LEFT) }}</span>
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 2px;">{{ $pengajuan->jenis_layanan }}</h2>
            </div>
            <div>
                @if($pengajuan->status == 'Menunggu Pemeriksaan')
                    <span class="badge badge-warning" style="font-size: 14px; padding: 6px 16px;">Menunggu Pemeriksaan</span>
                @elseif(in_array($pengajuan->status, ['Sedang Diproses', 'Disiapkan']))
                    <span class="badge badge-info" style="font-size: 14px; padding: 6px 16px;">{{ $pengajuan->status }}</span>
                @elseif(in_array($pengajuan->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                    <span class="badge badge-success" style="font-size: 14px; padding: 6px 16px;">{{ $pengajuan->status }}</span>
                @else
                    <span class="badge badge-danger" style="font-size: 14px; padding: 6px 16px;">Ditolak</span>
                @endif
            </div>
        </div>

        @php
            $statuses = ['Menunggu Pemeriksaan', 'Sedang Diproses', 'Disetujui', 'Siap Diambil', 'Selesai'];
            $currentIndex = array_search($pengajuan->status, $statuses);
            if ($currentIndex === false && $pengajuan->status !== 'Ditolak') {
                $currentIndex = 1; // Default fallback
            }
        @endphp

        <!-- Visual Stepper Timeline (Jika Tidak Ditolak) -->
        @if($pengajuan->status !== 'Ditolak')
            <div class="stepper-wrapper" style="--steps: {{ count($statuses) }}; --current: {{ $currentIndex }};">
                @foreach($statuses as $index => $statusName)
                    <div class="step-item {{ $index < $currentIndex ? 'completed' : ($index == $currentIndex ? 'active' : '') }}">
                        <div class="step-counter">
                            @if($index < $currentIndex)
                                <i data-lucide="check" style="width: 18px; height: 18px;"></i>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <div class="step-name">{{ $statusName }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rejection-box">
                <h4><i data-lucide="alert-triangle"></i> Permohonan Ditolak</h4>
                <p><strong>Alasan Penolakan:</strong> {{ $pengajuan->alasan_penolakan ?? 'Persyaratan data atau dokumen tidak memenuhi ketentuan sekolah. Silakan ajukan kembali permohonan baru.' }}</p>
            </div>
        @endif

        <!-- Details Grid -->
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Rencana Tanggal Pengambilan</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengambilan)->translatedFormat('d F Y') }}</div>
            </div>

            <!-- DOKUMEN LAMPIRAN DARI ALUMNI -->
            <div class="detail-item span-full" style="border: 1px dashed var(--border-color);">
                <div class="detail-label" style="font-weight: 600; color: var(--text-dark);">Dokumen Scan Mentah yang Anda Unggah</div>
                <div style="margin-top: 8px;">
                    @if($pengajuan->file_dokumen)
                        <div class="file-row">
                            <span style="font-size: 13px; font-weight: 600;">📄 File Lampiran Pengajuan</span>
                            <a href="{{ asset('storage/' . $pengajuan->file_dokumen) }}" target="_blank" class="btn btn-sm btn-outline" style="text-decoration: none; padding: 6px 14px; font-size: 12px;">
                                <i data-lucide="eye"></i> Lihat Dokumen Saya
                            </a>
                        </div>
                    @else
                        <span style="color: var(--text-muted); font-size: 13px; font-style: italic;">Tidak ada dokumen dilampirkan pada pengajuan ini.</span>
                    @endif
                </div>
            </div>

            <div class="detail-item span-full">
                <div class="detail-label">Alasan / Keperluan</div>
                <div class="detail-value" style="font-weight: 500; font-size: 14px; line-height: 1.5;">{{ $pengajuan->keperluan }}</div>
            </div>
        </div>

        <!-- DOKUMEN BALASAN LEGALISIR RESMI DARI PETUGAS KURIKULUM -->
        @if($pengajuan->file_balasan)
            <div class="download-card">
                <div class="download-card-title">
                    <i data-lucide="check-circle" style="color: #166534; width: 22px; height: 22px;"></i>
                    Dokumen Legalisir Resmi Siap Diunduh!
                </div>
                <p style="color: #15803d; font-size: 13px; margin-bottom: 16px; line-height: 1.5;">
                    Petugas Kurikulum telah mengonfirmasi dan mengunggah berkas hasil legalisir resmi untuk permohonan Anda.
                </p>
                <a href="{{ asset('storage/' . $pengajuan->file_balasan) }}" target="_blank" class="btn btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; font-size: 13px;">
                    <i data-lucide="download"></i> Download Dokumen Legalisir Resmi
                </a>
            </div>
        @endif
    </div>
</div>
@endsection