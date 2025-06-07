<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    protected $table = 'konseling';
    protected $fillable = [
        'pengaduan_id', 
        'korban_id', 
        'nama_korban', 
        'nama_konselor', 
        'jadwal_konseling',
        'tempat_konseling',
        'konfirmasi'
    ];

    protected $casts = [
        'jadwal_konseling' => 'datetime'
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
