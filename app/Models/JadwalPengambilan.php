<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPengambilan extends Model
{
    protected $table = 'jadwal_pengambilans';

    protected $fillable = [
        'pengajuan_id',
        'tanggal',
        'jam',
        'lokasi',
        'status',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}