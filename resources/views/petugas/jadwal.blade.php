@extends('layouts.app')

@section('title', 'Jadwal Pengambilan - DocuDemi')
@section('page-title', 'Jadwal Pengambilan')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700;">Jadwal Pengambilan</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Kelola jadwal pengambilan dokumen alumni.</p>
        </div>
    </div>

    <table class="table-container" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--bg-main); text-align: left; font-size: 12px; color: var(--text-muted);">
                <th style="padding: 12px;">ID PENGAJUAN</th>
                <th style="padding: 12px;">ALUMNI</th>
                <th style="padding: 12px;">LAYANAN</th>
                <th style="padding: 12px;">TANGGAL PENGAMBILAN</th>
                <th style="padding: 12px;">STATUS</th>
                <th style="padding: 12px; text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody style="font-size: 13px;">
            @forelse($jadwals as $item)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 14px; font-weight: 700; color: #15803D;">#DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 14px;">{{ $item->alumni->nama ?? '-' }}</td>
                    <td style="padding: 14px;">{{ $item->jenis_layanan }}</td>
                    <td style="padding: 14px;">{{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->translatedFormat('d M Y') }}</td>
                    <td style="padding: 14px;"><span class="badge badge-info">{{ $item->status }}</span></td>
                    <td style="padding: 14px; text-align: right;">
                        <a href="{{ route('petugas.pengajuan.show', $item->id) }}" style="color: #15803D; font-weight: 600; text-decoration: none;">Kelola Status</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        Belum ada jadwal pengambilan dokumen di database.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $jadwals->links() }}
    </div>
</div>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endsection