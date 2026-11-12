@extends('layouts.app')

@section('title', 'Riwayat Pengajuan - DocuDemi')
@section('page-title', 'Riwayat Permohonan')

@push('styles')
<style>
    /* Header Card UI Figma */
    .header-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .header-card h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .header-card p {
        font-size: 14px;
        color: var(--text-muted);
    }

    /* Container Table Modern */
    .table-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    .table-container {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container th {
        background-color: var(--bg-main);
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .table-container td {
        padding: 16px 20px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-container tr:last-child td {
        border-bottom: none;
    }

    .table-container tr:hover td {
        background-color: #F8FAFC;
    }

    .doc-id {
        font-weight: 700;
        color: var(--text-muted);
        font-family: monospace;
        font-size: 14px;
    }

    .service-badge-type {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        background-color: var(--bg-main);
        color: var(--text-muted);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')

    <!-- Header Section -->
    <div class="header-card">
        <h2>Arsip Riwayat Permohonan</h2>
        <p>Daftar riwayat permohonan layanan akademik Anda yang telah berstatus Selesai atau Ditolak.</p>
    </div>

    <!-- Table Section -->
    <div class="table-card">
        @if($pengajuans->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="archive" style="width: 32px; height: 32px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 6px;">Belum Ada Riwayat Arsip</h3>
                <p style="font-size: 14px; color: var(--text-muted);">Belum ada permohonan layanan dokumen yang selesai diproses atau ditolak.</p>
            </div>
        @else
            <table class="table-container">
                <thead>
                    <tr>
                        <th>ID Pengajuan</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Keperluan</th>
                        <th>Status Akhir</th>
                        <th style="text-align: right;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuans as $item)
                        <tr>
                            <td>
                                <span class="doc-id">#DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="service-badge-type">
                                    @if($item->jenis_layanan == 'Legalisir')
                                        <i data-lucide="file-check" style="width: 16px; height: 16px; color: var(--primary);"></i>
                                    @else
                                        <i data-lucide="book-open" style="width: 16px; height: 16px; color: var(--status-info);"></i>
                                    @endif
                                    {{ $item->jenis_layanan }}
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d M Y') }}</td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-muted);">
                                {{ $item->keperluan }}
                            </td>
                            <td>
                                @if($item->status == 'Selesai')
                                    <span class="badge badge-success"><i data-lucide="check-circle-2" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Selesai</span>
                                @else
                                    <span class="badge badge-danger"><i data-lucide="x-circle" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Ditolak</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('alumni.pengajuan.show', $item->id) }}" class="btn btn-outline" style="padding: 6px 14px; font-size: 12px;">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection