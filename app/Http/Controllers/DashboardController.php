<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pengaduan
        $totalPengaduan = Pengaduan::count();

        // Pengaduan berdasarkan status
        $pengaduanByStatus = Pengaduan::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Pengaduan berdasarkan bentuk kekerasan
        // Asumsi kolom bentuk_kekerasan ada di tabel pengaduan atau bisa dijoin
        // Jika bentuk_kekerasan ada di tabel terpisah dan berelasi, perlu join atau relasi
        // Untuk sementara, asumsikan ada kolom bentuk_kekerasan di tabel pengaduan
        $pengaduanByBentukKekerasan = Pengaduan::select('bentuk_kekerasan', DB::raw('count(*) as count'))
            ->groupBy('bentuk_kekerasan')
            ->pluck('count', 'bentuk_kekerasan');

        return view('staff.dashboard.index', compact('totalPengaduan', 'pengaduanByStatus', 'pengaduanByBentukKekerasan'));
    }
} 