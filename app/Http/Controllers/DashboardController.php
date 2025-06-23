<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Konseling;
use App\Models\Pendampingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $konselingMenunggu = 0;
        $pendampinganMenunggu = 0;

        if ($user->role === 'super_admin') {
            // Dashboard untuk super admin - hanya statistik dasar
            $totalPengaduan = Pengaduan::count();
            $pengaduanMenunggu = Pengaduan::where('status', 'menunggu')->count();
            $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
            $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
            
            $totalKonseling = Konseling::count();
            $totalPendampingan = Pendampingan::count();
            
            $recentPengaduan = Pengaduan::with(['korban', 'pelaku'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
                
            return view('dashboard.admin', compact(
                'totalPengaduan', 'pengaduanMenunggu', 'pengaduanDiproses', 'pengaduanSelesai',
                'totalKonseling', 'totalPendampingan', 'recentPengaduan',
                'konselingMenunggu', 'pendampinganMenunggu'
            ));
        } elseif ($user->role === 'staff') {
            // Dashboard untuk staff
            $totalPengaduan = Pengaduan::count();
            $pengaduanMenunggu = Pengaduan::where('status', 'menunggu')->count();
            $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
            $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
            
            $totalKonseling = Konseling::count();
            $konselingMenunggu = Konseling::where('konfirmasi', 'butuh_konfirmasi_staff')->count();
            
            $totalPendampingan = Pendampingan::count();
            $pendampinganMenunggu = Pendampingan::where('konfirmasi', 'butuh_konfirmasi_staff')->count();
            
            $recentPengaduan = Pengaduan::with(['korban', 'pelaku'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
                
        } else {
            // Dashboard untuk pelapor/user
            $totalPengaduan = Pengaduan::where('user_id', $user->id)->count();
            $pengaduanMenunggu = Pengaduan::where('user_id', $user->id)->where('status', 'menunggu')->count();
            $pengaduanDiproses = Pengaduan::where('user_id', $user->id)->where('status', 'diproses')->count();
            $pengaduanSelesai = Pengaduan::where('user_id', $user->id)->where('status', 'selesai')->count();
            
            $totalKonseling = Konseling::whereHas('pengaduan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
            
            $totalPendampingan = Pendampingan::whereHas('pengaduan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
            
            $recentPengaduan = Pengaduan::with(['korban', 'pelaku'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
        
        return view('dashboard.index', compact(
            'totalPengaduan', 'pengaduanMenunggu', 'pengaduanDiproses', 'pengaduanSelesai',
            'totalKonseling', 'totalPendampingan', 'recentPengaduan',
            'konselingMenunggu', 'pendampinganMenunggu'
        ));
    }
} 