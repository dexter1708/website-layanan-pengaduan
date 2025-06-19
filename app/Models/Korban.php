<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    protected $table = 'korban';
    protected $fillable = ['pengaduan_id', 'nama', 'jenis_kelamin', 'disabilitas', 'usia', 'no_telepon', 'pendidikan', 'status_perkawinan','pekerjaan'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function assessment()
    {
        return $this->hasOne(Assessment::class);
    }

    public function pendampingan()
    {
        return $this->hasOne(Pendampingan::class);
    }

    public function konseling()
    {
        return $this->hasMany(Konseling::class);
    }
}


