<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaku extends Model
{
    protected $table = 'pelaku';
    protected $fillable = ['pengaduan_id', 'nama', 'jenis_kelamin', 'usia', 'pendidikan', 'hubungan', 'kewarganegaraan','pekerjaan'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}


