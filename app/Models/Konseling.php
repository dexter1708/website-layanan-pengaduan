<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    protected $table = 'konseling';
    protected $fillable = [
        'pengaduan_id', 
        'korban_id', 
        'nama_korban', 
        'nama_konselor', 
        'jadwal_konseling',
        'tempat_konseling',
        'jenis_layanan',
        'konfirmasi'
    ];

    protected $casts = [
        'jadwal_konseling' => 'datetime'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class);
    }

    public function getJenisLayananLabel()
    {
        // Sekarang jenis_layanan menyimpan nama_layanan dari tabel layanan
        // Jadi langsung return saja karena sudah dalam format yang benar
        return $this->jenis_layanan;
    }

    public function getStatusLabel()
    {
        $labels = [
            'butuh_konfirmasi_staff' => 'Butuh Konfirmasi Staff',
            'menunggu_konfirmasi_user' => 'Menunggu Konfirmasi User',
            'menunggu' => 'Menunggu',
            'setuju' => 'Setuju',
            'tolak' => 'Tolak',
        ];

        return $labels[$this->konfirmasi] ?? $this->konfirmasi;
    }

    // Helper methods for Indonesian date formatting
    public function getJadwalKonselingFormatted()
    {
        return \Carbon\Carbon::parse($this->jadwal_konseling)->locale('id')->isoFormat('dddd, D MMMM Y');
    }

    public function getWaktuKonselingFormatted()
    {
        return \Carbon\Carbon::parse($this->jadwal_konseling)->format('H:i') . ' WIB';
    }

    public function getJadwalKonselingShort()
    {
        return \Carbon\Carbon::parse($this->jadwal_konseling)->locale('id')->isoFormat('D MMM Y');
    }

    public function getTanggalPengaduanFormatted()
    {
        return \Carbon\Carbon::parse($this->pengaduan->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
    }
}
