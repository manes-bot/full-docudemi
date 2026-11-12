<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Menampilkan daftar data Alumni dengan pencarian & paginasi.
     */
    public function index(Request $request)
    {
        $query = Alumni::withCount('pengajuans')->latest();

        // Pencarian berdasarkan Nama, NIS/NISN, Email, atau Jurusan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Jurusan
        if ($request->filled('jurusan') && $request->jurusan !== 'Semua') {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter berdasarkan Tahun Lulus
        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        $alumnis = $query->paginate(10)->withQueryString();

        return view('alumni.index', compact('alumnis'));
    }

    /**
     * Menampilkan detail data Alumni spesifik.
     */
    public function show($id)
    {
        $alumni = Alumni::with('pengajuans')->findOrFail($id);

        return view('alumni.show', compact('alumni'));
    }
}