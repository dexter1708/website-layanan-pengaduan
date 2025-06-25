<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    public $timestamps = false;

    protected $table = 'pekerjaan';
    
    protected $fillable = [
        'pekerjaan'
    ];
}

