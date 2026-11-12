<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetugasKurikulum extends Model
{
    protected $table = 'petugas_kurikulums';

    protected $fillable = [
        'nama',
        'username',
        'password',
    ];

    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }
}