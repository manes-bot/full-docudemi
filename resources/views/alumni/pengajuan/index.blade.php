@extends('layouts.app')

@section('title', 'Pengajuan Saya - DocuDemi')
@section('page-title', 'Pengajuan Saya')

@push('styles')
<style>
    /* Header Card Ringkasan UI Figma */
    .header-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .header-title p {
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
        color: var(--primary);
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

    /* Empty State Visual */
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
@endpush

@section('content')

    <!-- Header Section -->
    <div class="header-card">
        <div class="header-title">
            <h2>Daftar Permohonan Aktif</h2>
            <p>Pantau perkembangan dan status permohonan dokumen akademik Anda secara real-time.</p>
        </div>
        <a href="{{ route('alumni.pengajuan.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Ajukan Layanan Baru
        </a>
    </div>

    <!-- Table Section -->
    <div class="table-card">
        @if($pengajuans->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="file-x" style="width: 32px; height: 32px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 6px;">Belum Ada Pengajuan Aktif</h3>
                <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 20px;">Anda belum mengajukan permohonan legalisir maupun pengambilan Ijazah saat ini.</p>
                <a href="{{ route('alumni.pengajuan.create') }}" class="btn btn-primary">
                    <i data-lucide="file-plus"></i> Buat Pengajuan Sekarang
                </a>
            </div>
        @else
            <table class="table-container">
                <thead>
                    <tr>
                        <th>ID Pengajuan</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Rencana Pengambilan</th>
                        <th>Keperluan</th>
                        <th>Status Status</th>
                        <th style="text-align: right;">Aksi</th>
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
                                @if($item->status == 'Menunggu Pemeriksaan')
                                    <span class="badge badge-warning"><i data-lucide="clock" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Menunggu Pemeriksaan</span>
                                @elseif(in_array($item->status, ['Sedang Diproses', 'Disiapkan']))
                                    <span class="badge badge-info"><i data-lucide="loader" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> {{ $item->status }}</span>
                                @elseif(in_array($item->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                                    <span class="badge badge-success"><i data-lucide="check-circle" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> {{ $item->status }}</span>
                                @else
                                    <span class="badge badge-danger"><i data-lucide="alert-circle" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Ditolak</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('alumni.pengajuan.show', $item->id) }}" class="btn btn-outline" style="padding: 6px 14px; font-size: 12px;">
                                    Tracking Status <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection