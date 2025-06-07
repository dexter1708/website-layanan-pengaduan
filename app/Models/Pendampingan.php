<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendampingan extends Model
{
    protected $table = 'pendampingan';
    protected $fillable = [
        'pengaduan_id', 
        'korban_id', 
        'nama_korban', 
        'nama_pendamping',
        'tanggal_pendampingan',
        'tempat_pendampingan',
        'konfirmasi'
    ];

    protected $casts = [
        'tanggal_pendampingan' => 'datetime'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class);
    }
}

