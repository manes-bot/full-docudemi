@extends('layouts.app')

@section('title', 'Pengajuan Masuk - DocuDemi')
@section('page-title', 'Daftar Pengajuan Masuk')

@push('styles')
<style>
    .table-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
    }

    .table-container {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container th, .table-container td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .table-container th {
        background-color: var(--bg-main);
        color: var(--text-muted);
        font-weight: 600;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@endpush

@section('content')
<div class="table-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 4px;">Kelola Pengajuan Alumni</h2>
            <p style="font-size: 14px; color: var(--text-muted);">Periksa, setujui, siapkan dokumen, atau tolak permohonan alumni.</p>
        </div>
    </div>

    @if($pengajuans->isEmpty())
        <div style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
            <p>Tidak ada pengajuan permohonan ditemukan.</p>
        </div>
    @else
        <table class="table-container">
            <thead>
                <tr>
                    <th>No. Pengajuan</th>
                    <th>Nama Alumni</th>
                    <th>Jenis Layanan</th>
                    <th>Tgl Pengajuan</th>
                    <th>Rencana Pengambilan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $item)
                    <tr>
                        <td style="font-weight: 600; color: var(--primary);">
                            #DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="font-weight: 600;">{{ $item->alumni->nama ?? '-' }}</td>
                        <td>{{ $item->jenis_layanan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d M Y') }}</td>
                        <td>
                            @if($item->status == 'Menunggu Pemeriksaan')
                                <span class="badge badge-warning">Menunggu Pemeriksaan</span>
                            @elseif(in_array($item->status, ['Sedang Diproses', 'Disiapkan']))
                                <span class="badge badge-info">{{ $item->status }}</span>
                            @elseif(in_array($item->status, ['Disetujui', 'Siap Diambil', 'Selesai']))
                                <span class="badge badge-success">{{ $item->status }}</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('petugas.pengajuan.show', $item->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                Proses
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endsection