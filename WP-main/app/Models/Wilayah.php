<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah'; // Nama tabel yang menyimpan data wilayah
    protected $fillable = [
        'kota_id',
        'kecamatan_id',
        'desa_id',
        'kota_nama',
        'kecamatan_nama',
        'desa_nama'
    ];

    // Disable timestamps if your table doesn't have them
    public $timestamps = false;

    // Relationship untuk kota
    public function kota()
    {
        return $this->belongsTo(Wilayah::class, 'kota_id');
    }

    // Relationship untuk kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Wilayah::class, 'kecamatan_id');
    }

    // Relationship untuk desa
    public function desa()
    {
        return $this->belongsTo(Wilayah::class, 'desa_id');
    }

    // Scope untuk mendapatkan semua kota
    public function scopeOfKota($query)
    {
        return $query->whereNotNull('kota_nama')->whereNull('kecamatan_nama')->whereNull('desa_nama');
    }

    // Scope untuk mendapatkan semua kecamatan
    public function scopeOfKecamatan($query)
    {
        return $query->whereNotNull('kecamatan_nama')->whereNull('desa_nama');
    }

    // Scope untuk mendapatkan semua desa
    public function scopeOfDesa($query)
    {
        return $query->whereNotNull('desa_nama');
    }
}
