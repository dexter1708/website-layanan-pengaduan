<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    protected $table = 'pelapor';
    protected $fillable = ['pengaduan_id','user_id', 'nama_pelapor'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function alamat()
    {
        return $this->morphOne(Alamat::class, 'alamatable');
    }
}

