<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessment';

    protected $fillable = [
        'pengaduan_id',
        'korban_id',
        'nama_korban',
        'nama_assessor',
        'tanggal_assesment',
        'tempat_assessment',
        'konfirmasi'
    ];

    protected $casts = [
        'tanggal_assesment' => 'datetime',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class, 'korban_id');
    }
}

