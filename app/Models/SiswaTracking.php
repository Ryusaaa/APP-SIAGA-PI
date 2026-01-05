<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaTracking extends Model
{
    protected $fillable = [
        'siswa_id',
        'izin_id',
        'waktu_keluar',
        'waktu_kembali',
        'durasi_menit',
        'catatan'
    ];

    protected $casts = [
        'waktu_keluar' => 'datetime',
        'waktu_kembali' => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function izin(): BelongsTo
    {
        return $this->belongsTo(Izin::class);
    }
}