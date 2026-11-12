<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return Pengajuan::with('alumni')->latest()->get()->map(function ($pengajuan) {
            return [
                '#DOC-' . str_pad($pengajuan->id, 5, '0', STR_PAD_LEFT),
                $pengajuan->alumni->nama ?? '-',
                $pengajuan->jenis_layanan,
                $pengajuan->keperluan,
                $pengajuan->tanggal_pengajuan ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d-m-Y') : '-',
                $pengajuan->tanggal_pengambilan ? \Carbon\Carbon::parse($pengajuan->tanggal_pengambilan)->format('d-m-Y') : '-',
                $pengajuan->status,
                $pengajuan->alasan_penolakan ?? '-',
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'ID Pengajuan',
            'Nama Alumni',
            'Jenis Layanan',
            'Keperluan',
            'Tanggal Pengajuan',
            'Rencana Pengambilan',
            'Status',
            'Alasan Penolakan',
        ];
    }
}