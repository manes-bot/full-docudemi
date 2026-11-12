<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    protected $table = 'alumnis';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'nis_nisn',
        'no_hp',
        'tahun_lulus',
        'jurusan',
    ];

    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }
}