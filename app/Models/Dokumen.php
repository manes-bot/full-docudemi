<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $table = 'dokumens';

    protected $fillable = [
        'pengajuan_id',
        'nama_dokumen',
        'jenis_dokumen',
        'lokasi_file',
        'status_dokumen',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}