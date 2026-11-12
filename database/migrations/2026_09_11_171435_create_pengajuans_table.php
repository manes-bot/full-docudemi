<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            $table->foreignId('petugas_kurikulum_id')->nullable()->constrained('petugas_kurikulums')->onDelete('set null');
            $table->enum('jenis_layanan', ['Legalisir', 'Peminjaman Rapor']);
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_pengambilan')->nullable();
            $table->text('keperluan');
            $table->enum('status', [
                'Menunggu Pemeriksaan',
                'Sedang Diproses',
                'Disetujui',
                'Disiapkan',
                'Siap Diambil',
                'Selesai',
                'Ditolak'
            ])->default('Menunggu Pemeriksaan');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
