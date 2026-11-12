<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function create()
    {
        $alumni = Alumni::first();

        return view('alumni.pengajuan', compact('alumni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required',
            'tanggal_pengambilan' => 'required|date',
            'keperluan' => 'required',
        ]);

        $alumni = Alumni::first();

        Pengajuan::create([
            'alumni_id' => $alumni->id,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_pengajuan' => now()->toDateString(),
            'tanggal_pengambilan' => $request->tanggal_pengambilan,
            'keperluan' => $request->keperluan,
        ]);

        return redirect('/alumni/riwayat')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function riwayat()
    {
        $alumni = Alumni::first();

        $pengajuans = Pengajuan::where(
            'alumni_id',
            $alumni->id
        )->latest()->get();

        return view('alumni.riwayat', compact('pengajuans'));
    }
}