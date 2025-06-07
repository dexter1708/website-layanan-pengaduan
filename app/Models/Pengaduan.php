<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{

    protected $table = 'pengaduan';
    protected $fillable = [ 'user_id',
    'tempat_kejadian',
    'tanggal_kejadian',
    'jenis_laporan',
    'kronologi',
    'jenis_kasus',
    'bentuk_kekerasan',
    'kecamatan',
    'desa',
    'status',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelapor()
    {
        return $this->hasOne(Pelapor::class);
    }

    public function korban()
    {
        return $this->hasMany(Korban::class);
    }

    public function pelaku()
    {
        return $this->hasMany(Pelaku::class);
    }

    public function assessment()
    {
        return $this->hasMany(Assessment::class);
    }

    public function pendampingan()
    {
        return $this->hasMany(Pendampingan::class);
    }

    public function konseling()
    {
        return $this->hasMany(Konseling::class);
    }
}
