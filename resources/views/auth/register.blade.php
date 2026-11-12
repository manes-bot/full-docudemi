@extends('layouts.app')

@section('title', 'Daftar Alumni - DocuDemi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
<style>
    /* Mobile Branding Header Fix */
    .mobile-brand {
        display: none;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    .mobile-logo {
        width: 42px;
        height: 42px;
        background: #15803D;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(21, 128, 61, 0.25);
        flex-shrink: 0;
    }

    .mobile-brand-text h1 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        line-height: 1.2;
    }

    .mobile-brand-text p {
        font-size: 11px;
        color: var(--text-muted);
        margin: 2px 0 0 0;
    }

    /* Penyesuaian form row & group biar pas di card layout */
    .form-row {
        display: flex;
        gap: 14px;
    }

    .form-group {
        flex: 1;
        margin-bottom: 14px;
    }

    @media (max-width: 767px) {
        .mobile-brand {
            display: flex !important;
        }

        .auth-form-container {
            padding: 24px !important;
            max-height: none !important;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .form-group {
            margin-bottom: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-card" style="max-width: 950px;">
    <!-- Left Banner (Sama persis kayak halaman login) -->
    <div class="auth-banner" style="background: linear-gradient(135deg, rgba(21, 128, 61, 0.55) 0%, rgba(15, 81, 41, 0.75) 100%), radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 1.5px, transparent 1.5px), url('{{ asset('img/smk5hd.jpg') }}') center center / cover no-repeat !important; background-size: cover, 20px 20px, cover !important;">
        <div class="banner-brand">
            <div class="banner-logo">D</div>
            <div class="banner-title">
                <h1 style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">DocuDemi</h1>
                <p style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">SMKN 5 Surakarta</p>
            </div>
        </div>

        <div class="banner-body">
            <h2 style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Buat akun Alumni dengan mudah</h2>
            <p style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">Daftarkan diri Anda untuk mengakses layanan pengajuan legalisir dan peminjaman dokumen akademik secara online.</p>

            <div class="feature-list">
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Pengajuan Legalisir Ijazah Online</span>
                </div>
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Pantau Status Real-Time</span>
                </div>
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Pelayanan Dokumen Terintegrasi</span>
                </div>
            </div>
        </div>

        <div class="banner-footer" style="font-size: 11px; opacity: 0.95; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
            Jl. Adi Sucipto No. 42 Surakarta | www.smkn5solo.sch.id
        </div>
    </div>

    <!-- Right Form Container -->
    <div class="auth-form-container" style="overflow-y: auto; max-height: 88vh;">
        <!-- Mobile Header Branding -->
        <div class="mobile-brand">
            <div class="mobile-logo">D</div>
            <div class="mobile-brand-text">
                <h1>DocuDemi</h1>
                <p>SMKN 5 Surakarta</p>
            </div>
        </div>

        <div class="auth-header" style="margin-bottom: 16px;">
            <h2 style="font-size: 22px; margin-bottom: 4px;">Daftar Alumni</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Lengkapi data pribadi dan akademis Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Email Resmi</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">NIS / NISN</label>
                    <input type="text" name="nis_nisn" class="form-control" placeholder="Masukkan NIS / NISN" value="{{ old('nis_nisn') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Jurusan / Program Keahlian</label>
                    <select name="jurusan" class="form-control" required style="height: 42px;">
                        <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan</option>
                        <option value="Pengembangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)" {{ old('jurusan') == 'Pengembangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)' ? 'selected' : '' }}>PPLG / Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="Desain Pemodelan dan Informasi Bangunan (DPIB)" {{ old('jurusan') == 'Desain Pemodelan dan Informasi Bangunan (DPIB)' ? 'selected' : '' }}>Desain Pemodelan dan Informasi Bangunan (DPIB)</option>
                        <option value="Teknik Konstruksi dan Perumahan (TKP) / Bisnis Konstruksi dan Properti" {{ old('jurusan') == 'Teknik Konstruksi dan Perumahan (TKP) / Bisnis Konstruksi dan Properti' ? 'selected' : '' }}>Teknik Konstruksi & Properti (TKP/BKP)</option>
                        <option value="Teknik Mesin / Permesinan" {{ old('jurusan') == 'Teknik Mesin / Permesinan' ? 'selected' : '' }}>Teknik Mesin / Permesinan</option>
                        <option value="Teknik Kendaraan Ringan Otomotif (TKRO)" {{ old('jurusan') == 'Teknik Kendaraan Ringan Otomotif (TKRO)' ? 'selected' : '' }}>Teknik Kendaraan Ringan Otomotif (TKRO)</option>
                        <option value="Teknik dan Bisnis Sepeda Motor (TBSM)" {{ old('jurusan') == 'Teknik dan Bisnis Sepeda Motor (TBSM)' ? 'selected' : '' }}>Teknik dan Bisnis Sepeda Motor (TBSM)</option>
                        <option value="Teknik Elektronika Industri" {{ old('jurusan') == 'Teknik Elektronika Industri' ? 'selected' : '' }}>Teknik Elektronika Industri</option>
                        <option value="Teknik Otomasi Industri (TOI)" {{ old('jurusan') == 'Teknik Otomasi Industri (TOI)' ? 'selected' : '' }}>Teknik Otomasi Industri (TOI)</option>
                        <option value="Teknik Ketenagalistrikan / Teknik Instalasi Tenaga Listrik" {{ old('jurusan') == 'Teknik Ketenagalistrikan / Teknik Instalasi Tenaga Listrik' ? 'selected' : '' }}>Teknik Ketenagalistrikan / TITL</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" class="form-control" placeholder="Contoh: 2024" value="{{ old('tahun_lulus') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit" style="margin-top: 6px;">Daftar Akun Alumni</button>
        </form>

        @if ($errors->any())
            <div class="alert-error" style="margin-top: 14px; background: #FEE2E2; color: #B91C1C; padding: 10px 14px; border-radius: 8px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="auth-footer" style="margin-top: 18px; text-align: center; font-size: 13px; color: var(--text-muted);">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Masuk</a>
        </div>
    </div>
</div>
@endsection