<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class layanan extends Model
{
    protected $table = 'layanan';
    protected $fillable = ['nama_layanan', 'jenis_layanan'];
    public $timestamps = false;
}
