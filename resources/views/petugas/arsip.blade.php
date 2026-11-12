@extends('layouts.app')

@section('title', 'Arsip Dokumen - DocuDemi')
@section('page-title', 'Arsip Dokumen')

<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">s
@section('content')
<div class="card no-lift" style="padding: 24px;">
    <div class="card-head" style="margin-bottom: 20px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; margin: 0;">Arsip Dokumen</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Kelola dan kirimkan dokumen balasan/legalisir resmi ke Alumni.</p>
        </div>
        <!-- Tombol Trigger Modal Upload Balasan -->
        <button class="btn btn-primary" onclick="openUploadModal()">
            <i data-lucide="upload"></i> Upload Dokumen Balasan
        </button>
    </div>

    <!-- Table Dokumen -->
    <div class="table-responsive">
        <table class="table-container" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--bg-main); text-align: left; font-size: 12px; color: var(--text-muted);">
                    <th style="padding: 12px;">PERMOHONAN LAYANAN</th>
                    <th style="padding: 12px;">ALUMNI</th>
                    <th style="padding: 12px;">BERKAS ALUMNI</th>
                    <th style="padding: 12px;">BERKAS BALASAN</th>
                    <th style="padding: 12px;">STATUS</th>
                    <th style="padding: 12px; text-align: right;">AKSI</th>
                </tr>
            </thead>
            <tbody style="font-size: 13px;">
                @forelse($pengajuans as $item)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 14px; font-weight: 600;">
                            <i data-lucide="file-text" style="width: 16px; display: inline; vertical-align: middle; color: var(--primary);"></i> 
                            {{ $item->jenis_layanan }}
                        </td>
                        <td style="padding: 14px;">
                            <strong>{{ $item->alumni->nama ?? 'Alumni' }}</strong>
                            <div style="font-size: 11px; color: var(--text-muted);">{{ $item->alumni->jurusan ?? '-' }}</div>
                        </td>
                        <td style="padding: 14px;">
                            @if($item->file_dokumen)
                                <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                                    📄 Lihat Berkas
                                </a>
                            @else
                                <span style="color: var(--text-muted); font-size: 12px;">-</span>
                            @endif
                        </td>
                        <td style="padding: 14px;">
                            @if($item->file_balasan)
                                <a href="{{ asset('storage/' . $item->file_balasan) }}" target="_blank" style="color: #15803D; text-decoration: none; font-weight: 600;">
                                    ✓ Hasil Legalisir
                                </a>
                            @else
                                <span style="color: #D97706; font-size: 12px; font-style: italic;">Belum diunggah</span>
                            @endif
                        </td>
                        <td style="padding: 14px;">
                            <span class="badge" style="padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $item->status }}</span>
                        </td>
                        <td style="padding: 14px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                <button class="btn btn-sm btn-outline" onclick="openUploadModal('{{ $item->id }}')" style="padding: 4px 8px; font-size: 12px;">
                                    Upload Balasan
                                </button>
                                <a href="{{ route('petugas.pengajuan.show', $item->id) }}" style="color: #15803D; text-decoration: none; font-weight: 600; font-size: 13px;">Detail</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            Belum ada arsip pengajuan dokumen di database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Dialog Upload Dokumen Balasan -->
<div id="modalUpload" class="modal-overlay" style="display: none;">
    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalUploadTitle">
        <div class="modal-head">
            <h3 id="modalUploadTitle" style="font-size: 16px; font-weight: 700; margin: 0;">Upload Dokumen Balasan / Legalisir</h3>
            <button type="button" class="modal-close" onclick="closeUploadModal()" aria-label="Tutup">✕</button>
        </div>

        <form action="{{ route('petugas.arsip.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 6px;">Pilih Pengajuan Alumni</label>
                <select name="pengajuan_id" id="modal_pengajuan_id" class="form-control" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <option value="" disabled selected>-- Pilih Pengajuan --</option>
                    @foreach($pengajuans as $p)
                        <option value="{{ $p->id }}">{{ $p->alumni->nama ?? 'Alumni' }} - {{ $p->jenis_layanan }} ({{ $p->status }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 6px;">File Hasil Legalisir / Dokumen Resmi (PDF/Gambar Max 5MB)</label>
                <input type="file" name="file_balasan" class="form-control upload-box" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 6px;">Update Status Pengajuan</label>
                <select name="status" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <option value="Selesai" selected>Selesai</option>
                    <option value="Siap Diambil">Siap Diambil</option>
                    <option value="Sedang Diproses">Sedang Diproses</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan & Kirim Berkas</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openUploadModal(pengajuanId = '') {
        const modal = document.getElementById('modalUpload');
        const select = document.getElementById('modal_pengajuan_id');
        modal.style.display = 'flex';
        
        if (pengajuanId) {
            select.value = pengajuanId;
        }
    }

    function closeUploadModal() {
        document.getElementById('modalUpload').style.display = 'none';
    }
</script>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush