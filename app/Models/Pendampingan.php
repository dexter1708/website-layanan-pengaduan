<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendampingan extends Model
{
    protected $table = 'pendampingan';
    protected $fillable = [
        'pengaduan_id', 
        'korban_id', 
        'nama_korban',
        'nama_pendamping',
        'tanggal_pendampingan',
        'tempat_pendampingan',
        'jenis_layanan',
        'konfirmasi',
    ];

    protected $casts = [
        'tanggal_pendampingan' => 'datetime'
    ];

    // Constants for status
    const STATUS_BUTUH_KONFIRMASI_STAFF = 'butuh_konfirmasi_staff';
    const STATUS_MENUNGGU_KONFIRMASI_USER = 'menunggu_konfirmasi_user';
    const STATUS_TERKONFIRMASI = 'terkonfirmasi';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Auto-fill nama_korban from korban relationship
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pendampingan) {
            if ($pendampingan->korban_id && !$pendampingan->nama_korban) {
                $korban = \App\Models\Korban::find($pendampingan->korban_id);
                if ($korban) {
                    $pendampingan->nama_korban = $korban->nama;
                }
            }
        });
        
        static::updating(function ($pendampingan) {
            if ($pendampingan->isDirty('korban_id') && !$pendampingan->nama_korban) {
                $korban = \App\Models\Korban::find($pendampingan->korban_id);
                if ($korban) {
                    $pendampingan->nama_korban = $korban->nama;
                }
            }
        });
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class);
    }

    // Helper methods
    public function isButuhKonfirmasiStaff()
    {
        return $this->konfirmasi === self::STATUS_BUTUH_KONFIRMASI_STAFF;
    }

    public function isMenungguKonfirmasiUser()
    {
        return $this->konfirmasi === self::STATUS_MENUNGGU_KONFIRMASI_USER;
    }

    public function isTerkonfirmasi()
    {
        return $this->konfirmasi === self::STATUS_TERKONFIRMASI;
    }

    public function isDibatalkan()
    {
        return $this->konfirmasi === self::STATUS_DIBATALKAN;
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
            self::STATUS_BUTUH_KONFIRMASI_STAFF => 'Butuh Konfirmasi Staff',
            self::STATUS_MENUNGGU_KONFIRMASI_USER => 'Menunggu Konfirmasi User',
            self::STATUS_TERKONFIRMASI => 'Terkonfirmasi',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
        ];

        return $labels[$this->konfirmasi] ?? $this->konfirmasi;
    }

    // Helper methods for Indonesian date formatting
    public function getTanggalPendampinganFormatted()
    {
        return \Carbon\Carbon::parse($this->tanggal_pendampingan)->locale('id')->isoFormat('dddd, D MMMM Y');
    }

    public function getWaktuPendampinganFormatted()
    {
        return \Carbon\Carbon::parse($this->tanggal_pendampingan)->format('H:i') . ' WIB';
    }

    public function getTanggalPendampinganShort()
    {
        return \Carbon\Carbon::parse($this->tanggal_pendampingan)->locale('id')->isoFormat('D MMM Y');
    }

    public function getTanggalPengaduanFormatted()
    {
        return \Carbon\Carbon::parse($this->pengaduan->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
    }
}

