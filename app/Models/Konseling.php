<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    const STATUS_BUTUH_KONFIRMASI_STAFF = 'butuh_konfirmasi_staff';
    const STATUS_MENUNGGU_KONFIRMASI_USER = 'menunggu_konfirmasi_user';
    const STATUS_TERKONFIRMASI = 'terkonfirmasi';
    const STATUS_DIBATALKAN = 'dibatalkan';

    protected $table = 'konseling';
    protected $appends = ['status_label', 'status_badge_class'];
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

    public function getStatusLabelAttribute()
    {
        return match ($this->konfirmasi) {
            self::STATUS_BUTUH_KONFIRMASI_STAFF => 'Menunggu Konfirmasi Staff',
            self::STATUS_MENUNGGU_KONFIRMASI_USER => 'Menunggu Konfirmasi Anda',
            self::STATUS_TERKONFIRMASI => 'Terkonfirmasi',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            'setuju' => 'Terkonfirmasi', // Fallback for old data
            'tolak' => 'Dibatalkan', // Fallback for old data
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->konfirmasi) {
            self::STATUS_BUTUH_KONFIRMASI_STAFF => 'bg-yellow-500',
            self::STATUS_MENUNGGU_KONFIRMASI_USER => 'bg-blue-500',
            self::STATUS_TERKONFIRMASI => 'bg-green-500',
            self::STATUS_DIBATALKAN => 'bg-red-500',
            'setuju' => 'bg-green-500', // Fallback for old data
            'tolak' => 'bg-red-500', // Fallback for old data
            default => 'bg-gray-400',
        };
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
