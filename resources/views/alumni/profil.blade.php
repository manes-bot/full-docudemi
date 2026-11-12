@extends('layouts.app')

@section('title', 'Profil Saya - DocuDemi')
@section('page-title', 'Profil Alumni')

@push('styles')
<style>
    .profile-card {
        max-width: 720px;
        margin: 0 auto;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 24px;
    }

    .profile-avatar-lg {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background-color: var(--light-accent);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .info-group {
        background-color: var(--bg-main);
        padding: 16px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .info-group.full-width {
        grid-column: span 2;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        word-break: break-word;
    }

    @media (max-width: 600px) {
        .profile-info-grid {
            grid-template-columns: 1fr;
        }
        .info-group.full-width {
            grid-column: span 1;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')
<div class="profile-card">
    <div class="card" style="padding: 28px;">
        <div class="profile-header">
            <div class="profile-avatar-lg">
                {{ strtoupper(substr($alumni->nama ?? $user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 22px; font-weight: 700; margin: 0; color: var(--text-dark);">{{ $alumni->nama ?? $user->name }}</h2>
                <p style="font-size: 14px; color: var(--text-muted); margin: 4px 0 0;">Alumni SMKN 5 Surakarta</p>
            </div>
        </div>

        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: var(--text-dark);">Informasi Identitas & Kontak</h3>

        <div class="profile-info-grid">
            <div class="info-group">
                <div class="info-label">NIS / NISN</div>
                <div class="info-value">{{ $alumni->nis_nisn ?? '-' }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Tahun Lulus</div>
                <div class="info-value">{{ $alumni->tahun_lulus ?? '-' }}</div>
            </div>

            <div class="info-group full-width">
                <div class="info-label">Jurusan / Program Keahlian</div>
                <div class="info-value" style="color: var(--primary);">{{ $alumni->jurusan ?? '-' }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Alamat Email</div>
                <div class="info-value">{{ $alumni->email ?? $user->email }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Nomor WhatsApp / HP</div>
                <div class="info-value">{{ $alumni->no_hp ?? '-' }}</div>
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('alumni.dashboard') }}" class="btn btn-outline" style="text-decoration: none;">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection