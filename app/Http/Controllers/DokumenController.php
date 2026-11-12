<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Simpan Upload Dokumen Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'alumni_id'    => 'required|exists:alumnis,id',
            'jenis_dokumen'=> 'required|in:Ijazah,Rapor,Transkip,Lainnya',
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5048', // Maksimal 5MB
        ], [
            'alumni_id.required'     => 'Pilih alumni pemilik dokumen.',
            'jenis_dokumen.required' => 'Pilih jenis dokumen.',
            'nama_dokumen.required'  => 'Masukkan nama dokumen.',
            'file_dokumen.required'  => 'Pilih file dokumen yang ingin di-upload.',
            'file_dokumen.mimes'     => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file_dokumen.max'       => 'Ukuran file maksimal 5MB.',
        ]);

        // Upload File ke folder public/dokumen
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen', 'public');

            Dokumen::create([
                'alumni_id'    => $request->alumni_id,
                'jenis_dokumen'=> $request->jenis_dokumen,
                'nama_dokumen' => $request->nama_dokumen,
                'file_path'    => $filePath,
                'status'       => 'Aktif',
            ]);
        }

        return back()->with('success', 'Dokumen berhasil di-upload dan tersimpan di arsip!');
    }
}