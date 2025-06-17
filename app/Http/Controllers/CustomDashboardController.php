<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
// use App\Models\Assessment;
use App\Models\Konseling;
use App\Models\Pendampingan;

class CustomDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'staff' || $user->role === 'super_admin') {
            // Dashboard untuk staff dan super admin
            $totalPengaduan = Pengaduan::count();
            $pengaduanMenunggu = Pengaduan::where('status', 'menunggu')->count();
            $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
            $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
            
            // Assessment feature disabled
            // $totalAssessment = Assessment::count();
            $totalKonseling = Konseling::count();
            $totalPendampingan = Pendampingan::count();
            
            $pengaduanTerbaru = Pengaduan::with(['pelapor', 'korban'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('dashboard.staff', compact(
                'totalPengaduan',
                'pengaduanMenunggu',
                'pengaduanDiproses',
                'pengaduanSelesai',
                // 'totalAssessment',
                'totalKonseling',
                'totalPendampingan',
                'pengaduanTerbaru'
            ));
        } else {
            // Dashboard untuk pelapor
            $pengaduanUser = Pengaduan::where('user_id', $user->id)
                ->with(['assessment', 'konseling', 'pendampingan'])
                ->latest()
                ->take(5)
                ->get();
                
            $totalPengaduanUser = Pengaduan::where('user_id', $user->id)->count();
            $pengaduanMenungguUser = Pengaduan::where('user_id', $user->id)
                ->where('status', 'menunggu')
                ->count();
            $pengaduanDiprosesUser = Pengaduan::where('user_id', $user->id)
                ->where('status', 'diproses')
                ->count();
            $pengaduanSelesaiUser = Pengaduan::where('user_id', $user->id)
                ->where('status', 'selesai')
                ->count();
                
            return view('dashboard.pelapor', compact(
                'pengaduanUser',
                'totalPengaduanUser',
                'pengaduanMenungguUser',
                'pengaduanDiprosesUser',
                'pengaduanSelesaiUser'
            ));
        }
    }
} 