<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BentukKekerasan extends Model
{
    protected $table = 'bentuk_kekerasan';
    
    protected $fillable = [
        'bentuk_kekerasan'
    ];
    public $timestamps = false;
}
