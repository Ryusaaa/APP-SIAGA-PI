<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'jurusan_id',
        'mapel_id',
        'alasan',
        'mapel',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

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
