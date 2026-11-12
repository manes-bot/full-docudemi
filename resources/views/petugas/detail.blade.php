@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan - DocuDemi')
@section('page-title', 'Verifikasi Permohonan Dokumen')

@push('styles')
<style>
    .detail-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
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

    .action-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-top: 24px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-dark);
        outline: none;
        margin-bottom: 16px;
        background-color: var(--surface);
    }

    .form-control:focus {
        border-color: var(--primary);
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')
<div class="detail-container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('petugas.pengajuan.index') }}" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">
            <i data-lucide="arrow-left"></i> Kembali ke Pengajuan
        </a>
    </div>

    <!-- Informasi Detail -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
            <div>
                <span style="font-size: 12px; color: var(--text-muted);">ID Pengajuan: #DOC-{{ str_pad($pengajuan->id, 5, '0', STR_PAD_LEFT) }}</span>
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 2px;">{{ $pengajuan->jenis_layanan }}</h2>
            </div>
            <div>
                <span class="badge badge-info" style="font-size: 14px; padding: 6px 16px;">{{ $pengajuan->status }}</span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Nama Alumni Pemohon</div>
                <div class="detail-value">{{ $pengajuan->alumni->nama ?? ($pengajuan->alumni->name ?? '-') }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">NIS / NISN</div>
                <div class="detail-value">{{ $pengajuan->alumni->nis_nisn ?? '-' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Rencana Tanggal Pengambilan</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengambilan)->translatedFormat('d F Y') }}</div>
            </div>

            <!-- DOKUMEN LAMPIRAN ALUMNI -->
            <div class="detail-item" style="grid-column: span 2; border: 1px dashed var(--border-color);">
                <div class="detail-label" style="font-weight: 600; color: var(--text-dark);">Dokumen Lampiran Alumni</div>
                <div style="margin-top: 8px;">
                    @if($pengajuan->file_dokumen)
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 13px; font-weight: 500;">📄 File Scan Berkas Alumni</span>
                            <a href="{{ asset('storage/' . $pengajuan->file_dokumen) }}" target="_blank" class="btn btn-sm btn-primary" style="text-decoration: none; padding: 6px 14px; font-size: 13px;">
                                <i data-lucide="eye"></i> Lihat / Download Dokumen
                            </a>
                        </div>
                    @else
                        <span style="color: var(--text-muted); font-size: 13px; font-style: italic;">Tidak ada dokumen dilampirkan oleh alumni.</span>
                    @endif
                </div>
            </div>

            <div class="detail-item" style="grid-column: span 2;">
                <div class="detail-label">Alasan / Keperluan</div>
                <div class="detail-value" style="font-weight: 500; font-size: 14px;">{{ $pengajuan->keperluan }}</div>
            </div>
        </div>
    </div>

    <!-- Card Form Aksi Verifikasi -->
    <div class="action-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Update Status & Upload Balasan</h3>

        <form action="{{ route('petugas.pengajuan.updateStatus', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Pilih Status Permohonan</label>
                <select name="status" id="statusSelect" class="form-control" onchange="toggleRejectionReason()">
                    <option value="Menunggu Pemeriksaan" {{ $pengajuan->status == 'Menunggu Pemeriksaan' ? 'selected' : '' }}>Menunggu Pemeriksaan</option>
                    <option value="Sedang Diproses" {{ $pengajuan->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="Disetujui" {{ $pengajuan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Disiapkan" {{ $pengajuan->status == 'Disiapkan' ? 'selected' : '' }}>Disiapkan</option>
                    <option value="Siap Diambil" {{ $pengajuan->status == 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- UPLOAD BALASAN LEGALISIR RESMI -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Upload Hasil Legalisir / Dokumen Resmi (Opsional)</label>
                <input type="file" name="file_balasan" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @if($pengajuan->file_balasan)
                    <div style="margin-top: -8px; margin-bottom: 12px; font-size: 13px; color: #15803D; font-weight: 600;">
                        ✓ Berkas balasan telah diunggah: 
                        <a href="{{ asset('storage/' . $pengajuan->file_balasan) }}" target="_blank" style="color: #15803D; text-decoration: underline;">Lihat Berkas Balasan</a>
                    </div>
                @endif
            </div>

            <div id="rejectionReasonGroup" style="display: {{ $pengajuan->status == 'Ditolak' ? 'block' : 'none' }}; margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: var(--status-danger);">Alasan Penolakan</label>
                <textarea name="alasan_penolakan" class="form-control" style="min-height: 90px;" placeholder="Tuliskan alasan penolakan permohonan agar alumni dapat mengetahui alasannya...">{{ old('alasan_penolakan', $pengajuan->alasan_penolakan) }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Simpan Status & Berkas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleRejectionReason() {
        const status = document.getElementById('statusSelect').value;
        const reasonGroup = document.getElementById('rejectionReasonGroup');
        
        if (status === 'Ditolak') {
            reasonGroup.style.display = 'block';
        } else {
            reasonGroup.style.display = 'none';
        }
    }
</script>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush