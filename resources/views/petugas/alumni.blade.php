@extends('layouts.app')

@section('title', 'Data Alumni - DocuDemi')
@section('page-title', 'Data Alumni')

<link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
@section('content')
<div class="card">
    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 700;">Data Alumni</h2>
        <p style="font-size: 13px; color: var(--text-muted);">{{ $alumnis->total() }} alumni terdaftar di database</p>
    </div>

    <form action="{{ route('petugas.alumni') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 12px;">
        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama, NIS/NISN, atau email..." style="max-width: 400px;">
        <button type="submit" class="btn btn-outline">Cari</button>
    </form>

    <table class="table-container" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--bg-main); text-align: left; font-size: 12px; color: var(--text-muted);">
                <th style="padding: 12px;">NIS/NISN</th>
                <th style="padding: 12px;">NAMA</th>
                <th style="padding: 12px;">EMAIL</th>
                <th style="padding: 12px;">NOMOR HP</th>
                <th style="padding: 12px;">TAHUN LULUS</th>
                <th style="padding: 12px;">TOTAL PENGAJUAN</th>
            </tr>
        </thead>
        <tbody style="font-size: 13px;">
            @forelse($alumnis as $item)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 14px; font-weight: 700; color: #15803D;">{{ $item->nis_nisn ?? '-' }}</td>
                    <td style="padding: 14px; font-weight: 600;">{{ $item->nama }}</td>
                    <td style="padding: 14px;">{{ $item->email }}</td>
                    <td style="padding: 14px;">{{ $item->no_hp ?? '-' }}</td>
                    <td style="padding: 14px;">{{ $item->tahun_lulus ?? '-' }}</td>
                    <td style="padding: 14px; font-weight: 700; color: #15803D;">{{ $item->pengajuans_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        Belum ada data alumni terdaftar di database.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $alumnis->links() }}
    </div>
</div>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endsection