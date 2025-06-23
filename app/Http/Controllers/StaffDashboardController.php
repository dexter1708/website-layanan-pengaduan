<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Konseling;
use App\Models\Pendampingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Statistik pengaduan
        $totalPengaduan = Pengaduan::count();
        $pengaduanMenunggu = Pengaduan::where('status', 'menunggu')->count();
        $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        
        // Statistik layanan
        $totalKonseling = Konseling::count();
        $totalPendampingan = Pendampingan::count();
        
        // Pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::with(['korban', 'pelaku'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Pengaduan berdasarkan status (menggantikan bentuk kekerasan)
        $pengaduanByStatus = Pengaduan::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        return view('staff.dashboard.index', compact(
            'totalPengaduan',
            'pengaduanMenunggu',
            'pengaduanDiproses',
            'pengaduanSelesai',
            'totalKonseling',
            'totalPendampingan',
            'pengaduanTerbaru',
            'pengaduanByStatus'
        ));
    }
} 