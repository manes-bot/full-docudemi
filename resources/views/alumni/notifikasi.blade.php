@extends('layouts.app')

@section('title', 'Notifikasi Pengajuan - DocuDemi')
@section('page-title', 'Notifikasi Status Layanan')

@push('styles')
<style>
    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .notification-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: all 0.2s ease;
    }

    .notification-card:hover {
        border-color: var(--primary);
    }

    .notification-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-content {
        flex-grow: 1;
    }

    .notification-title {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-dark);
    }

    .notification-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .notification-time {
        font-size: 12px;
        color: #94A3B8;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 4px;">Pemberitahuan Status</h2>
        <p style="font-size: 14px; color: var(--text-muted);">Pantau setiap pembaruan status permohonan dokumen akademik Anda di sini.</p>
    </div>

    @if($notifikasis->isEmpty())
        <div class="card" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
            <i data-lucide="bell-off" style="width: 48px; height: 48px; margin-bottom: 12px; stroke-width: 1.5;"></i>
            <p>Belum ada notifikasi atau aktivitas permohonan baru.</p>
        </div>
    @else
        <div class="notification-list">
            @foreach($notifikasis as $item)
                <div class="notification-card">
                    @if($item->status == 'Menunggu Pemeriksaan')
                        <div class="notification-icon" style="background-color: #FEF3C7; color: #D97706;">
                            <i data-lucide="clock"></i>
                        </div>
                    @elseif(in_array($item->status, ['Sedang Diproses', 'Disiapkan']))
                        <div class="notification-icon" style="background-color: #DBEAFE; color: #1D4ED8;">
                            <i data-lucide="loader"></i>
                        </div>
                    @elseif(in_array($item->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                        <div class="notification-icon" style="background-color: #DCFCE7; color: #15803D;">
                            <i data-lucide="check-circle"></i>
                        </div>
                    @else
                        <div class="notification-icon" style="background-color: #FEE2E2; color: #B91C1C;">
                            <i data-lucide="alert-triangle"></i>
                        </div>
                    @endif

                    <div class="notification-content">
                        <div class="notification-title">
                            Permohonan {{ $item->jenis_layanan }} (#DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }})
                        </div>
                        <div class="notification-desc">
                            Status permohonan Anda telah diperbarui menjadi <strong>"{{ $item->status }}"</strong>. 
                            @if($item->status == 'Siap Diambil')
                                Silakan datang ke ruang Kurikulum sekolah sesuai jadwal pengambilan pada tanggal {{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d F Y') }}.
                            @elseif($item->status == 'Ditolak')
                                Catatan: {{ $item->alasan_penolakan ?? 'Persyaratan data belum sesuai.' }}
                            @endif
                        </div>
                        <div class="notification-time">
                            {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                        </div>
                    </div>

                    <a href="{{ route('alumni.pengajuan.show', $item->id) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">
                        Detail
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection