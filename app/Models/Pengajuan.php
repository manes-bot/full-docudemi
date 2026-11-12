<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    protected $table = 'pengajuans';

    protected $fillable = [
        'alumni_id',
        'id_petugas',
        'jenis_layanan',
        'tanggal_pengajuan',
        'tanggal_pengambilan',
        'keperluan',
        'file_dokumen', // <--- WAJIB ADA (Berkas Upload Alumni)
        'file_balasan', // <--- WAJIB ADA (Berkas Legalisir Petugas)
        'status',
        'catatan',
        'alasan_penolakan',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(PetugasKurikulum::class, 'id_petugas');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'id_pengajuan');
    }

    public function jadwalPengambilan(): HasOne
    {
        return $this->hasOne(JadwalPengambilan::class, 'id_pengajuan');
    }
}