<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PetugasKurikulumController;
use App\Http\Controllers\DokumenController;

/*
|--------------------------------------------------------------------------
| Web Routes - DocuDemi
|--------------------------------------------------------------------------
*/

// Halaman Utama: landing page untuk tamu, redirect ke dashboard jika sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'petugas' 
            ? redirect()->route('petugas.dashboard') 
            : redirect()->route('alumni.dashboard');
    }
    return view('landing'); // Diubah dari 'landing' ke 'welcome'
});

// Autentikasi (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (Authenticated Users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// ROLE: ALUMNI
// ==========================================
Route::middleware(['auth', 'role:alumni'])->prefix('alumni')->name('alumni.')->group(function () {
    Route::get('/dashboard', [PengajuanController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/riwayat', [PengajuanController::class, 'riwayat'])->name('riwayat');
    Route::get('/notifikasi', [PengajuanController::class, 'notifikasi'])->name('notifikasi');
    Route::get('/profil', [PengajuanController::class, 'profil'])->name('profil');
});

// ==========================================
// ROLE: PETUGAS KURIKULUM
// ==========================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasKurikulumController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan', [PetugasKurikulumController::class, 'pengajuanMasuk'])->name('pengajuan.index');
    Route::get('/pengajuan/{id}', [PetugasKurikulumController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{id}/status', [PetugasKurikulumController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    
    Route::get('/arsip', [PetugasKurikulumController::class, 'arsipDokumen'])->name('arsip');
    Route::post('/arsip/upload', [PetugasKurikulumController::class, 'uploadArsip'])->name('arsip.upload');
    
    Route::get('/jadwal', [PetugasKurikulumController::class, 'jadwalPengambilan'])->name('jadwal');
    Route::get('/alumni', [PetugasKurikulumController::class, 'dataAlumni'])->name('alumni');
    
    Route::get('/laporan', [PetugasKurikulumController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export-excel', [PetugasKurikulumController::class, 'exportExcel'])->name('laporan.export');
    
    Route::get('/notifikasi', [PetugasKurikulumController::class, 'notifikasi'])->name('notifikasi');
    Route::post('/dokumen/upload', [DokumenController::class, 'store'])->name('dokumen.upload');
    
    Route::get('/profil', [PetugasKurikulumController::class, 'profil'])->name('profil');
    Route::post('/profil', [PetugasKurikulumController::class, 'updateProfil'])->name('profil.update');
});