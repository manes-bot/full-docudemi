<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    /**
     * Dashboard Alumni
     */
    public function dashboard()
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();

        $totalPengajuan = 0;
        $sedangDiproses = 0;
        $pengajuanAktif = 0;
        $siapDiambil    = 0;
        $selesai        = 0;
        $pengajuanTerbaru = collect();

        if ($alumni) {
            $totalPengajuan = Pengajuan::where('alumni_id', $alumni->id)->count();
            
            $sedangDiproses = Pengajuan::where('alumni_id', $alumni->id)
                ->whereIn('status', ['Menunggu Pemeriksaan', 'Sedang Diproses', 'Disetujui', 'Disiapkan'])
                ->count();
                
            $pengajuanAktif = $sedangDiproses;
            
            $siapDiambil = Pengajuan::where('alumni_id', $alumni->id)
                ->where('status', 'Siap Diambil')
                ->count();
                
            $selesai = Pengajuan::where('alumni_id', $alumni->id)
                ->where('status', 'Selesai')
                ->count();
                
            $pengajuanTerbaru = Pengajuan::where('alumni_id', $alumni->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('alumni.dashboard', compact(
            'user', 
            'alumni', 
            'totalPengajuan', 
            'sedangDiproses',
            'pengajuanAktif', 
            'siapDiambil', 
            'selesai', 
            'pengajuanTerbaru'
        ));
    }

    /**
     * Daftar Pengajuan Saya
     */
    public function index()
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();

        $pengajuans = $alumni 
            ? Pengajuan::where('alumni_id', $alumni->id)->latest()->paginate(10) 
            : collect();

        return view('alumni.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Form Pengajuan Layanan
     */
    public function create()
    {
        return view('alumni.pengajuan.create');
    }

    /**
     * Simpan Pengajuan Baru (SUDAH DIBETULKAN UNTUK FILE UPLOAD)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_layanan'       => 'required|string',
            'tanggal_pengambilan' => 'required|date|after_or_equal:today',
            'keperluan'           => 'required|string',
            'file_dokumen'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'jenis_layanan.required'             => 'Pilih jenis layanan.',
            'tanggal_pengambilan.required'        => 'Pilih tanggal rencana pengambilan.',
            'tanggal_pengambilan.after_or_equal' => 'Rencana tanggal pengambilan tidak boleh lewat dari hari ini.',
            'keperluan.required'                 => 'Tuliskan alasan/keperluan pengajuan.',
            'file_dokumen.mimes'                 => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_dokumen.max'                   => 'Ukuran file maksimal 5MB.',
        ]);

        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();

        if (!$alumni) {
            return back()->withErrors([
                'keperluan' => 'Data profil Alumni Anda belum terhubung di database. Silakan periksa kembali akun Anda.'
            ])->withInput();
        }

        // TANGKAP DAN SIMPAN FILE JIKA ALUMNI MENGUNGGAH BERKAS
        $filePath = null;
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_pengajuan', 'public');
        }

        Pengajuan::create([
            'alumni_id'           => $alumni->id,
            'jenis_layanan'       => $validated['jenis_layanan'],
            'tanggal_pengajuan'   => now(),
            'tanggal_pengambilan' => $validated['tanggal_pengambilan'],
            'keperluan'           => $validated['keperluan'],
            'file_dokumen'        => $filePath, // <--- DISIMPAN KE DATABASE
            'status'              => 'Menunggu Pemeriksaan',
        ]);

        return redirect()->route('alumni.pengajuan.index')
            ->with('success', 'Pengajuan layanan berhasil dikirim dan sedang menunggu pemeriksaan!');
    }

    /**
     * Detail Pengajuan
     */
    public function show($id)
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->firstOrFail();

        $pengajuan = Pengajuan::where('id', $id)
            ->where('alumni_id', $alumni->id)
            ->firstOrFail();

        return view('alumni.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Riwayat
     */
    public function riwayat()
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();
        
        $pengajuans = $alumni 
            ? Pengajuan::where('alumni_id', $alumni->id)
                ->whereIn('status', ['Selesai', 'Ditolak'])
                ->latest()
                ->get() 
            : collect();

        $riwayats = $pengajuans;

        return view('alumni.riwayat', compact('pengajuans', 'riwayats'));
    }

    /**
     * Notifikasi Alumni
     */
    public function notifikasi()
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();
        
        $notifikasis = $alumni 
            ? Pengajuan::where('alumni_id', $alumni->id)->latest()->take(10)->get() 
            : collect();

        return view('alumni.notifikasi', compact('notifikasis'));
    }

    /**
     * Profil Alumni
     */
    public function profil()
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->first();

        return view('alumni.profil', compact('user', 'alumni'));
    }

    /**
     * Update Profil Alumni
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $alumni = Alumni::where('email', $user->email)->firstOrFail();

        $request->validate([
            'name'     => 'required|string|max:255',
            'no_hp'    => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $alumni->nama  = $request->name;
        $alumni->no_hp = $request->no_hp;
        $alumni->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}