<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;
    protected $fillable = [
        'identitas',
        'nama',
        'jurusan_id',
        'instansi',
        'kemana',
        'keperluan',    
        'no_telp',
        'captured_photo'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
