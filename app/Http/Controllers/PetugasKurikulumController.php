<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pengajuan;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasKurikulumController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $totalPengajuan   = Pengajuan::count();
        $pengajuanBaru    = Pengajuan::whereDate('created_at', '>=', now()->subDays(2))->count();
        $perluPemeriksaan = Pengajuan::where('status', 'Menunggu Pemeriksaan')->count();
        $sedangDiproses   = Pengajuan::whereIn('status', ['Sedang Diproses', 'Disetujui', 'Disiapkan'])->count();
        $siapDiambil      = Pengajuan::where('status', 'Siap Diambil')->count();
        $selesaiBulanIni  = Pengajuan::where('status', 'Selesai')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        $pengajuanTerbaru = Pengajuan::with('alumni')->latest()->take(5)->get();
        $perluTindakan    = Pengajuan::with('alumni')->where('status', 'Menunggu Pemeriksaan')->latest()->take(3)->get();
        $siapDiambilList  = Pengajuan::with('alumni')->where('status', 'Siap Diambil')->latest()->take(3)->get();

        return view('petugas.dashboard', compact(
            'user', 'totalPengajuan', 'pengajuanBaru', 'perluPemeriksaan',
            'sedangDiproses', 'siapDiambil', 'selesaiBulanIni',
            'pengajuanTerbaru', 'perluTindakan', 'siapDiambilList'
        ));
    }

    public function pengajuanMasuk(Request $request)
    {
        $query = Pengajuan::with('alumni')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhereHas('alumni', function ($a) use ($search) {
                      $a->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->paginate(10);
        return view('petugas.pengajuan', compact('pengajuans'));
    }

    public function arsipDokumen(Request $request)
    {
        $query = Pengajuan::with('alumni')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('alumni', function ($a) use ($search) {
                $a->where('nama', 'like', "%{$search}%");
            });
        }

        $pengajuans = $query->paginate(10);
        return view('petugas.arsip', compact('pengajuans'));
    }

    /**
     * Upload Dokumen Balasan / Hasil Legalisir dari Halaman Arsip
     */
    public function uploadArsip(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuans,id',
            'file_balasan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5048',
            'status'       => 'required|string',
        ], [
            'pengajuan_id.required' => 'Pilih permohonan alumni terlebih dahulu.',
            'file_balasan.required' => 'Pilih file hasil legalisir yang akan di-upload.',
            'file_balasan.mimes'    => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_balasan.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $pengajuan = Pengajuan::findOrFail($request->pengajuan_id);

        if ($request->hasFile('file_balasan')) {
            // Hapus file balasan lama jika ada
            if ($pengajuan->file_balasan && Storage::disk('public')->exists($pengajuan->file_balasan)) {
                Storage::disk('public')->delete($pengajuan->file_balasan);
            }

            $filePath = $request->file('file_balasan')->store('dokumen_balasan', 'public');
            $pengajuan->file_balasan = $filePath;
        }

        $pengajuan->status = $request->status;
        $pengajuan->save();

        return back()->with('success', 'Dokumen hasil legalisir berhasil di-upload dan dikirimkan ke Alumni!');
    }

    public function jadwalPengambilan()
    {
        $jadwals = Pengajuan::with('alumni')
            ->whereIn('status', ['Disetujui', 'Disiapkan', 'Siap Diambil', 'Selesai'])
            ->latest()
            ->paginate(10);

        return view('petugas.jadwal', compact('jadwals'));
    }

    public function dataAlumni(Request $request)
    {
        $query = Alumni::withCount('pengajuans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $alumnis = $query->paginate(10);
        return view('petugas.alumni', compact('alumnis'));
    }

    public function laporan()
    {
        $totalPengajuan = Pengajuan::count();
        $totalLegalisir = Pengajuan::where('jenis_layanan', 'like', '%Legalisir%')->count();
        $totalRapor     = Pengajuan::where('jenis_layanan', 'like', '%Pengambilan Ijazah%')->count();
        $totalSelesai   = Pengajuan::where('status', 'Selesai')->count();
        $totalDitolak   = Pengajuan::where('status', 'Ditolak')->count();
        $totalDiproses  = Pengajuan::whereIn('status', ['Menunggu Pemeriksaan', 'Sedang Diproses', 'Disetujui', 'Disiapkan'])->count();

        $donutData = [
            'selesai'  => $totalSelesai,
            'diproses' => $totalDiproses,
            'ditolak'  => $totalDitolak
        ];

        $months = [];
        $legalisirMonthly = [];
        $raporMonthly = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M');

            $legalisirMonthly[] = Pengajuan::where('jenis_layanan', 'like', '%Legalisir%')
                ->whereMonth('tanggal_pengajuan', $date->month)
                ->whereYear('tanggal_pengajuan', $date->year)
                ->count();

            $raporMonthly[] = Pengajuan::where('jenis_layanan', 'like', '%Pengambilan Ijazah%')
                ->whereMonth('tanggal_pengajuan', $date->month)
                ->whereYear('tanggal_pengajuan', $date->year)
                ->count();
        }

        $legalisirSelesai = Pengajuan::where('jenis_layanan', 'like', '%Legalisir%')->where('status', 'Selesai')->count();
        $legalisirProses  = Pengajuan::where('jenis_layanan', 'like', '%Legalisir%')->whereIn('status', ['Menunggu Pemeriksaan', 'Sedang Diproses', 'Disetujui', 'Disiapkan'])->count();

        $raporSelesai = Pengajuan::where('jenis_layanan', 'like', '%Pengambilan Ijazah%')->where('status', 'Selesai')->count();
        $raporProses  = Pengajuan::where('jenis_layanan', 'like', '%Pengambilan Ijazah%')->whereIn('status', ['Menunggu Pemeriksaan', 'Sedang Diproses', 'Disetujui', 'Disiapkan'])->count();

        return view('petugas.laporan', compact(
            'totalPengajuan', 'totalLegalisir', 'totalRapor', 'totalSelesai',
            'totalDitolak', 'totalDiproses', 'donutData', 'months',
            'legalisirMonthly', 'raporMonthly', 'legalisirSelesai',
            'legalisirProses', 'raporSelesai', 'raporProses'
        ));
    }

    public function exportExcel()
    {
        $fileName = 'Laporan_Pengajuan_DocuDemi_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LaporanExport, $fileName);
    }

    public function notifikasi()
    {
        $notifikasis = Pengajuan::with('alumni')->latest('updated_at')->take(10)->get();
        return view('petugas.notifikasi', compact('notifikasis'));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('petugas.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('alumni')->findOrFail($id);
        return view('petugas.detail', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'           => 'required',
            'alasan_penolakan' => 'required_if:status,Ditolak|nullable|string',
            'file_balasan'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $request->status;

        if ($request->status === 'Ditolak') {
            $pengajuan->alasan_penolakan = $request->alasan_penolakan;
        }

        if ($request->hasFile('file_balasan')) {
            if ($pengajuan->file_balasan && Storage::disk('public')->exists($pengajuan->file_balasan)) {
                Storage::disk('public')->delete($pengajuan->file_balasan);
            }
            $filePath = $request->file('file_balasan')->store('dokumen_balasan', 'public');
            $pengajuan->file_balasan = $filePath;
        }

        $pengajuan->save();

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}