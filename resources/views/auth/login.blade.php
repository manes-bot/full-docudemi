@extends('layouts.app')

@section('title', 'Masuk - DocuDemi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
<style>
    /* Mobile Branding Header Fix */
    .mobile-brand {
        display: none;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
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

    @media (max-width: 767px) {
        .mobile-brand {
            display: flex !important;
        }

        .auth-header {
            margin-bottom: 20px;
        }

        .auth-header h2 {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .auth-header p {
            font-size: 12px;
            margin: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-card">
    <!-- Left Banner (Overlay Transparan + Foto Gerbang SMKN 5 Terang) -->
    <div class="auth-banner" style="background: linear-gradient(135deg, rgba(21, 128, 61, 0.55) 0%, rgba(15, 81, 41, 0.75) 100%), radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 1.5px, transparent 1.5px), url('{{ asset('img/smk5hd.jpg') }}') center center / cover no-repeat !important; background-size: cover, 20px 20px, cover !important;">
        <div class="banner-brand">
            <div class="banner-logo">D</div>
            <div class="banner-title">
                <h1 style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">DocuDemi</h1>
                <p style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">SMKN 5 Surakarta</p>
            </div>
        </div>

        <div class="banner-body">
            <h2 style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Sistem Informasi Dokumen & Legalisir Alumni</h2>
            <p style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">Platform resmi pelayanan dokumen akademik alumni SMKN 5 Surakarta.</p>

            <div class="feature-list">
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Pengajuan Legalisir Ijazah Online</span>
                </div>
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Verifikasi Berkas Kurikulum</span>
                </div>
                <div class="feature-item" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                    <i data-lucide="check"></i>
                    <span>Pantau Status Real-Time</span>
                </div>
            </div>
        </div>

        <div class="banner-footer" style="font-size: 11px; opacity: 0.95; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
            Jl. Adi Sucipto No. 42 Surakarta | www.smkn5solo.sch.id
        </div>
    </div>

    <!-- Right Form (Responsive & Mobile Branding) -->
    <div class="auth-form-container">
        <!-- Header Branding khusus Layar Mobile (HP) -->
        <div class="mobile-brand">
            <div class="mobile-logo">D</div>
            <div class="mobile-brand-text">
                <h1>DocuDemi</h1>
                <p>SMKN 5 Surakarta</p>
            </div>
        </div>

        <div class="auth-header">
            <h2>Masuk</h2>
            <p>Pilih peran dan masukkan kredensial Anda</p>
        </div>

        <!-- Role Switcher -->
        @php
            $selectedRole = old('role_type', 'alumni');
        @endphp

        <div class="role-switcher">
            <button type="button" class="role-tab {{ $selectedRole === 'alumni' ? 'active' : '' }}" id="tab-alumni" onclick="switchRole('alumni')">
                Alumni
            </button>
            <button type="button" class="role-tab {{ $selectedRole === 'petugas' ? 'active' : '' }}" id="tab-petugas" onclick="switchRole('petugas')">
                Petugas Kurikulum
            </button>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Penanda Role yang Dikirim ke Controller -->
            <input type="hidden" name="role_type" id="role_input" value="{{ $selectedRole }}">

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" id="identity_label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                    {{ $selectedRole === 'alumni' ? 'NIS / NISN' : 'Email Petugas' }}
                </label>
                <input type="text" name="identity" id="identity_input" class="form-control" 
                       placeholder="{{ $selectedRole === 'alumni' ? 'Masukkan NIS / NISN' : 'Masukkan email petugas kurikulum' }}" 
                       value="{{ old('identity') }}" required autofocus>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>

            @if($errors->has('identity'))
                <div class="alert-error" style="margin-top: 14px; background: #FEE2E2; color: #B91C1C; padding: 10px 14px; border-radius: 8px; font-size: 13px;">
                    {{ $errors->first('identity') }}
                </div>
            @endif
        </form>

        <div class="auth-footer" id="register_link" style="display: {{ $selectedRole === 'alumni' ? 'block' : 'none' }};">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai Alumni</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchRole(role) {
        document.getElementById('role_input').value = role;
        
        const tabAlumni = document.getElementById('tab-alumni');
        const tabPetugas = document.getElementById('tab-petugas');
        const identityLabel = document.getElementById('identity_label');
        const identityInput = document.getElementById('identity_input');
        const registerLink = document.getElementById('register_link');

        if (role === 'alumni') {
            tabAlumni.classList.add('active');
            tabPetugas.classList.remove('active');
            identityLabel.innerText = 'NIS / NISN';
            identityInput.placeholder = 'Masukkan NIS / NISN';
            registerLink.style.display = 'block';
        } else {
            tabPetugas.classList.add('active');
            tabAlumni.classList.remove('active');
            identityLabel.innerText = 'Email Petugas';
            identityInput.placeholder = 'Masukkan email petugas kurikulum';
            registerLink.style.display = 'none';
        }
    }
</script>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endpush