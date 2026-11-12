@extends('layouts.app')

@section('title', 'Ajukan Layanan - DocuDemi')
@section('page-title', 'Ajukan Layanan Akademik')

@push('styles')
<style>
    .form-container {
        max-width: 720px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-label span {
        color: var(--status-danger);
    }

    /* Card Selector untuk Jenis Layanan */
    .service-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .service-card {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background-color: var(--surface);
    }

    .service-card:hover {
        border-color: var(--secondary);
    }

    .service-card.active {
        border-color: var(--primary);
        background-color: var(--light-accent);
    }

    .service-card input[type="radio"] {
        margin-top: 4px;
        accent-color: var(--primary);
    }

    .service-info h4 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-dark);
    }

    .service-info p {
        font-size: 12px;
        color: var(--text-muted);
        line-height: 1.4;
    }

    /* Input & Textarea */
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-dark);
        background-color: var(--surface);
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 110px;
    }

    .info-box {
        background-color: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 10px;
        padding: 16px;
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .info-box i {
        color: #2563EB;
        flex-shrink: 0;
    }

    .info-box p {
        font-size: 13px;
        color: #1E40AF;
        line-height: 1.5;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
    }

    @media (max-width: 600px) {
        .service-options {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="card no-lift">
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Form Permohonan Layanan</h2>
        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 28px;">Silakan isi formulir di bawah ini dengan lengkap untuk mengajukan permohonan dokumen.</p>

        @if($errors->any())
            <div style="background-color: #FEE2E2; color: #B91C1C; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumni.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pilihan Layanan -->
            <div class="form-group">
                <label class="form-label">Jenis Layanan <span>*</span></label>
                <div class="service-options">
                    <label class="service-card {{ old('jenis_layanan', 'Legalisir Ijazah / Transkrip') == 'Legalisir Ijazah / Transkrip' ? 'active' : '' }}" id="card-legalisir" onclick="selectService('Legalisir Ijazah / Transkrip')">
                        <input type="radio" name="jenis_layanan" id="radio-legalisir" value="Legalisir Ijazah / Transkrip" {{ old('jenis_layanan', 'Legalisir Ijazah / Transkrip') == 'Legalisir Ijazah / Transkrip' ? 'checked' : '' }}>
                        <div class="service-info">
                            <h4>Legalisir Ijazah / Transkrip</h4>
                            <p>Pengesahan salinan fotokopi Ijazah / Transkrip Nilai oleh pihak sekolah.</p>
                        </div>
                    </label>

                    <label class="service-card {{ old('jenis_layanan') == 'Pengambilan Ijazah' ? 'active' : '' }}" id="card-ijazah" onclick="selectService('Pengambilan Ijazah')">
                        <input type="radio" name="jenis_layanan" id="radio-ijazah" value="Pengambilan Ijazah" {{ old('jenis_layanan') == 'Pengambilan Ijazah' ? 'checked' : '' }}>
                        <div class="service-info">
                            <h4>Pengambilan Ijazah</h4>
                            <p>Pengambilan fisik dokumen Ijazah asli yang tersimpan di sekolah.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Upload Dokumen Lampiran (Hanya tampil saat Legalisir) -->
            <div class="form-group" id="wrapper-upload-dokumen">
                <label class="form-label" for="file_dokumen">Upload Berkas Ijazah / Transkrip <span>*</span> <span style="font-weight: 400; color: var(--text-muted);">(PDF, JPG, PNG, Max 5MB)</span></label>
                <input type="file" id="file_dokumen" name="file_dokumen" class="form-control upload-box" accept=".pdf,.jpg,.jpeg,.png">
                <small style="color: var(--text-muted); font-size: 12px; margin-top: 4px; display: block;">Unggah berkas scan Ijazah/Transkrip yang ingin dilegalisir.</small>
            </div>

            <!-- Tanggal Pengambilan -->
            <div class="form-group">
                <label class="form-label" for="tanggal_pengambilan">Rencana Tanggal Pengambilan <span>*</span></label>
                <input type="date" id="tanggal_pengambilan" name="tanggal_pengambilan" class="form-control" value="{{ old('tanggal_pengambilan', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
            </div>

            <!-- Keperluan -->
            <div class="form-group">
                <label class="form-label" for="keperluan">Alasan / Keperluan <span>*</span></label>
                <textarea id="keperluan" name="keperluan" class="form-control" placeholder="Tuliskan alasan atau keperluan pengajuan dokumen Anda secara singkat dan jelas..." required>{{ old('keperluan') }}</textarea>
            </div>

            <!-- Notice Box -->
            <div class="info-box">
                <i data-lucide="info"></i>
                <p id="notice-text">
                    <strong>Catatan Penting:</strong> Pastikan dokumen yang diunggah dapat terbaca dengan jelas untuk mempermudah proses legalisir oleh Petugas Kurikulum.
                </p>
            </div>

            <!-- Buttons -->
            <div class="form-actions">
                <a href="{{ route('alumni.dashboard') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="send"></i> Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectService(serviceName) {
        const cardLegalisir = document.getElementById('card-legalisir');
        const cardIjazah = document.getElementById('card-ijazah');
        const radioLegalisir = document.getElementById('radio-legalisir');
        const radioIjazah = document.getElementById('radio-ijazah');
        const wrapperUpload = document.getElementById('wrapper-upload-dokumen');
        const inputUpload = document.getElementById('file_dokumen');
        const noticeText = document.getElementById('notice-text');

        cardLegalisir.classList.remove('active');
        cardIjazah.classList.remove('active');

        if (serviceName === 'Legalisir Ijazah / Transkrip') {
            cardLegalisir.classList.add('active');
            radioLegalisir.checked = true;
            
            // Tampilkan field upload & buat required jika legalisir
            wrapperUpload.style.display = 'block';
            inputUpload.required = true;

            noticeText.innerHTML = '<strong>Catatan Penting:</strong> Pastikan dokumen scan yang diunggah dapat terbaca dengan jelas untuk mempermudah proses legalisir oleh Petugas Kurikulum.';
        } else {
            cardIjazah.classList.add('active');
            radioIjazah.checked = true;

            // Sembunyikan field upload & lepas atribut required
            wrapperUpload.style.display = 'none';
            inputUpload.required = false;

            noticeText.innerHTML = '<strong>Catatan Penting:</strong> Anda tidak perlu mengunggah berkas. Silakan datang ke sekolah sesuai dengan rencana tanggal pengambilan yang dijadwalkan.';
        }
    }

    // Run on initial load to handle old input state
    document.addEventListener("DOMContentLoaded", function() {
        const selected = document.querySelector('input[name="jenis_layanan"]:checked');
        if (selected) {
            selectService(selected.value);
        } else {
            selectService('Legalisir Ijazah / Transkrip');
        }
    });
</script>
@endpush