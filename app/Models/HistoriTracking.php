<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriTracking extends Model
{
    protected $table = 'histori_tracking';
    
    protected $fillable = [
        'pengaduan_id',
        'status_sebelum',
        'status_sesudah',
        'changed_by_user_id',
        'keterangan'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
