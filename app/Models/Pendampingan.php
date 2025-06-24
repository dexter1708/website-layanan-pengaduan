<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pendampingan extends Model
{
    use HasFactory;
    
    protected $table = 'pendampingan';
    protected $guarded = ['id'];
    protected $appends = ['status_label', 'status_badge_class'];

    // Constants for status
    public const STATUS_BUTUH_KONFIRMASI_STAFF = 'butuh_konfirmasi_staff';
    public const STATUS_MENUNGGU_KONFIRMASI_USER = 'menunggu_konfirmasi_user';
    public const STATUS_TERKONFIRMASI = 'terkonfirmasi';
    public const STATUS_DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'pengaduan_id',
        'korban_id',
        'nama_pendamping',
        'tanggal_pendampingan',
        'tempat_pendampingan',
        'jenis_layanan',
        'konfirmasi',
    ];

    protected $casts = [
        'tanggal_pendampingan' => 'datetime'
    ];

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
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class, 'korban_id');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->konfirmasi) {
            self::STATUS_BUTUH_KONFIRMASI_STAFF => 'Menunggu Konfirmasi Staff',
            self::STATUS_MENUNGGU_KONFIRMASI_USER => 'Menunggu Konfirmasi Pelapor',
            self::STATUS_TERKONFIRMASI => 'Terkonfirmasi',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
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
            default => 'bg-gray-400',
        };
    }

    public function getJenisLayananLabel()
    {
        // Sekarang jenis_layanan menyimpan nama_layanan dari tabel layanan
        // Jadi langsung return saja karena sudah dalam format yang benar
        return $this->jenis_layanan;
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

