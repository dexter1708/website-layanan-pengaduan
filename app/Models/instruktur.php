<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class instruktur extends Model
{
    protected $table = 'instruktur';
    protected $fillable = ['nama', 'posisi', 'foto', 'nama_layanan'];
    public $timestamps = false;

    public function layanan()
    {
        return $this->belongsTo(layanan::class, 'nama_layanan', 'nama_layanan');
    }
}
