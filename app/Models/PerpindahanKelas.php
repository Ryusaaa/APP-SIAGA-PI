<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerpindahanKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'jurusan_id',
        'mapel_id',
        'jumlah_siswa',
        'mapel',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}

