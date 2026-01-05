<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mapel extends Model
{
    protected $fillable = ['kode', 'nama', 'jurusan_id', 'jam_pelajaran', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}