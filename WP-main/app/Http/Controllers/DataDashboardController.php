<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Korban;
use App\Models\Pelaku;
// use App\Models\Assessment;
use App\Models\Konseling;
use App\Models\Pendampingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DataDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query dengan eager loading
        $query = Pengaduan::with(['korban', 'pelapor', 'pelaku']);

        // Filter berdasarkan jumlah korban
        if ($request->filled('jumlah_korban')) {
            $query->whereHas('korban', function($q) use ($request) {
                $q->havingRaw('COUNT(*) = ?', [$request->jumlah_korban]);
            });
        }

        // Filter berdasarkan bentuk kekerasan
        if ($request->filled('bentuk_kekerasan')) {
            $query->where('bentuk_kekerasan', $request->bentuk_kekerasan);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan role user
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }

        // Hitung total pengaduan
        $totalPengaduan = $query->count();

        // Hitung pengaduan berdasarkan status
        $pengaduanByStatus = $query->clone()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Hitung jumlah pengaduan per status untuk card statistik
        $pengaduanMenunggu = $pengaduanByStatus['menunggu'] ?? 0;
        $pengaduanDiproses = $pengaduanByStatus['diproses'] ?? 0;
        $pengaduanSelesai = $pengaduanByStatus['selesai'] ?? 0;

        // Service statistics
        // Assessment feature disabled
        // $totalAssessment = Assessment::count();
        $totalKonseling = Konseling::count();
        $totalPendampingan = Pendampingan::count();

        // User statistics (hanya untuk staff/admin)
        $totalUsers = 0;
        $totalStaff = 0;
        if ($user->role === 'staff' || $user->role === 'super_admin') {
            $totalUsers = User::where('role', 'pelapor')->count();
            $totalStaff = User::whereIn('role', ['staff', 'super_admin'])->count();
        }

        // Statistik Korban
        $statistikKorban = $query->clone()
            ->with('korban')
            ->get()
            ->flatMap->korban
            ->groupBy('jenis_kelamin')
            ->map(function($group) {
                return [
                    'total' => $group->count(),
                    'usia' => [
                        'anak' => $group->where('usia', '<', 18)->count(),
                        'dewasa' => $group->where('usia', '>=', 18)->count()
                    ],
                    'disabilitas' => $group->where('disabilitas', 'Ya')->count(),
                    'pendidikan' => $group->groupBy('pendidikan')
                        ->map->count(),
                    'status_perkawinan' => $group->groupBy('status_perkawinan')
                        ->map->count(),
                    'pekerjaan' => $group->groupBy('pekerjaan')
                        ->map->count()
                ];
            });

        // Statistik Pelaku
        $statistikPelaku = $query->clone()
            ->with('pelaku')
            ->get()
            ->flatMap->pelaku
            ->groupBy('jenis_kelamin')
            ->map(function($group) {
                return [
                    'total' => $group->count(),
                    'usia' => [
                        'anak' => $group->where('usia', '<', 18)->count(),
                        'dewasa' => $group->where('usia', '>=', 18)->count()
                    ],
                    'pendidikan' => $group->groupBy('pendidikan')
                        ->map->count(),
                    'hubungan' => $group->groupBy('hubungan')
                        ->map->count(),
                    'kewarganegaraan' => $group->groupBy('kewarganegaraan')
                        ->map->count(),
                    'pekerjaan' => $group->groupBy('pekerjaan')
                        ->map->count()
                ];
            });

        // Hitung pengaduan berdasarkan jumlah korban
        $pengaduanByJumlahKorban = $query->clone()
            ->withCount('korban')
            ->get()
            ->groupBy('korban_count')
            ->map->count();

        // Hitung pengaduan berdasarkan bentuk kekerasan
        $pengaduanByBentukKekerasan = $query->clone()
            ->selectRaw('bentuk_kekerasan, count(*) as total')
            ->groupBy('bentuk_kekerasan')
            ->pluck('total', 'bentuk_kekerasan');

        // Hitung trend bulanan (6 bulan terakhir)
        $pengaduanByBulan = $query->clone()
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, DATE_FORMAT(created_at, "%M %Y") as label, count(*) as total')
            ->groupBy('month', 'label')
            ->orderBy('month')
            ->get();

        // Top kecamatan dengan most cases (hanya untuk staff/admin)
        $topKecamatan = collect();
        if ($user->role === 'staff' || $user->role === 'super_admin') {
            $topKecamatan = Pengaduan::selectRaw('kecamatan, count(*) as total')
                ->groupBy('kecamatan')
                ->orderByDesc('total')
                ->take(5)
                ->get();
        }

        // Gender distribution of korban
        $korbanGender = Korban::selectRaw('jenis_kelamin, count(*) as total')
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        // Age group distribution of korban
        $korbanAgeGroups = Korban::selectRaw('
            CASE 
                WHEN usia < 18 THEN "Anak-anak"
                WHEN usia BETWEEN 18 AND 25 THEN "Remaja"
                WHEN usia BETWEEN 26 AND 40 THEN "Dewasa Muda"
                WHEN usia BETWEEN 41 AND 60 THEN "Dewasa"
                ELSE "Lansia"
            END as age_group,
            count(*) as total
        ')
        ->groupBy('age_group')
        ->pluck('total', 'age_group');

        // Ambil pengaduan terbaru
        $pengaduanTerbaru = $query->clone()
            ->with(['pelapor', 'korban'])
            ->latest()
            ->take(5)
            ->get();

        // Recent assessments, konseling, and pendampingan
        // Assessment feature disabled
        // $recentAssessments = Assessment::with('pengaduan')
        //     ->latest()
        //     ->take(3)
        //     ->get();
            
        $recentKonseling = Konseling::with('pengaduan')
            ->latest()
            ->take(3)
            ->get();
            
        $recentPendampingan = Pendampingan::with('pengaduan')
            ->latest()
            ->take(3)
            ->get();

        // Data untuk filter
        $jumlahKorbanOptions = $pengaduanByJumlahKorban->keys()->sort()->values();
        $bentukKekerasanOptions = $pengaduanByBentukKekerasan->keys()->filter()->values();
        $statusOptions = $pengaduanByStatus->keys()->values();

        return view('data-dashboard.index', compact(
            'totalPengaduan',
            'pengaduanMenunggu',
            'pengaduanDiproses',
            'pengaduanSelesai',
            // 'totalAssessment',
            'totalKonseling',
            'totalPendampingan',
            'totalUsers',
            'totalStaff',
            'pengaduanByStatus',
            'pengaduanByJumlahKorban',
            'pengaduanByBentukKekerasan',
            'pengaduanByBulan',
            'pengaduanTerbaru',
            'jumlahKorbanOptions',
            'bentukKekerasanOptions',
            'statusOptions',
            'statistikKorban',
            'statistikPelaku',
            'topKecamatan',
            'korbanGender',
            'korbanAgeGroups',
            // 'recentAssessments',
            'recentKonseling',
            'recentPendampingan'
        ));
    }

    /**
     * Get dashboard data for API calls (for AJAX requests)
     */
    public function getDashboardData(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'basic');
        
        switch ($type) {
            case 'monthly-trend':
                return $this->getMonthlyTrend($user);
            case 'status-distribution':
                return $this->getStatusDistribution($user);
            case 'recent-activities':
                return $this->getRecentActivities($user);
            default:
                return $this->getBasicStats($user);
        }
    }
    
    private function getBasicStats($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        return response()->json([
            'totalPengaduan' => $query->count(),
            'pengaduanMenunggu' => $query->clone()->where('status', 'menunggu')->count(),
            'pengaduanDiproses' => $query->clone()->where('status', 'diproses')->count(),
            'pengaduanSelesai' => $query->clone()->where('status', 'selesai')->count(),
            // 'totalAssessment' => Assessment::count(),
            'totalKonseling' => Konseling::count(),
            'totalPendampingan' => Pendampingan::count(),
        ]);
    }
    
    private function getMonthlyTrend($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        $trend = $query->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, DATE_FORMAT(created_at, "%M %Y") as label, count(*) as total')
            ->groupBy('month', 'label')
            ->orderBy('month')
            ->get();
            
        return response()->json($trend);
    }
    
    private function getStatusDistribution($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        $distribution = $query->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
            
        return response()->json($distribution);
    }
    
    private function getRecentActivities($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        $activities = $query->with(['pelapor', 'korban', /* 'assessment', */ 'konseling', 'pendampingan'])
            ->latest()
            ->take(5)
            ->get();
        
        return response()->json($activities);
    }
} 