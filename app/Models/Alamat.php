<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat';
    
    protected $fillable = [
        'nama',
        'sebagai',
        'kota',
        'kecamatan',
        'desa',
        'RT',
        'RW'
    ];

    public function alamatable()
    {
        return $this->morphTo();
    }
}


