<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Korban;
use App\Models\Pelaku;
use App\Models\Konseling;
use App\Models\Pendampingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsDashboardController extends Controller
{
    /**
     * Display the analytics dashboard with role-based data.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'staff' || $user->role === 'super_admin') {
            return $this->staffAnalytics();
        } else {
            return $this->pelaporAnalytics();
        }
    }

    /**
     * Analytics dashboard for staff and super admin
     */
    private function staffAnalytics()
    {
        // Basic statistics
        $totalPengaduan = Pengaduan::count();
        $pengaduanMenunggu = Pengaduan::where('status', 'menunggu')->count();
        $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        
        // Service statistics
        $totalKonseling = Konseling::count();
        $totalPendampingan = Pendampingan::count();
        
        // User statistics
        $totalUsers = User::where('role', 'pelapor')->count();
        $totalStaff = User::whereIn('role', ['staff', 'super_admin'])->count();
        
        // Recent activities
        $pengaduanTerbaru = Pengaduan::with(['pelapor', 'korban'])
            ->latest()
            ->take(5)
            ->get();
            
        // Monthly trend (last 6 months)
        $monthlyTrend = Pengaduan::where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, DATE_FORMAT(created_at, "%M %Y") as label, count(*) as total')
            ->groupBy('month', 'label')
            ->orderBy('month')
            ->get();
            
        // Status distribution
        $statusDistribution = Pengaduan::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
            
        // Top kecamatan with most cases
        $topKecamatan = Pengaduan::selectRaw('kecamatan, count(*) as total')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->take(5)
            ->get();
            
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
        
        return view('analytics.staff', compact(
            'totalPengaduan',
            'pengaduanMenunggu',
            'pengaduanDiproses',
            'pengaduanSelesai',
            'totalKonseling',
            'totalPendampingan',
            'totalUsers',
            'totalStaff',
            'pengaduanTerbaru',
            'monthlyTrend',
            'statusDistribution',
            'topKecamatan',
            'korbanGender',
            'korbanAgeGroups',
            // 'recentAssessments',
            'recentKonseling',
            'recentPendampingan'
        ));
    }

    /**
     * Analytics dashboard for pelapor (regular users)
     */
    private function pelaporAnalytics()
    {
        $user = Auth::user();
        
        // User's pengaduan statistics
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
            
        // User's recent pengaduan
        $pengaduanUser = Pengaduan::where('user_id', $user->id)
            ->with([/* 'assessment', */ 'konseling', 'pendampingan', 'korban', 'pelaku'])
            ->latest()
            ->take(5)
            ->get();
            
        // User's service statistics
        $totalKonselingUser = Konseling::whereHas('pengaduan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        
        $totalPendampinganUser = Pendampingan::whereHas('pengaduan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        
        // Recent activities for user
        // Assessment feature disabled
        // $recentAssessmentsUser = Assessment::whereHas('pengaduan', function($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })
        // ->with('pengaduan')
        // ->latest()
        // ->take(3)
        // ->get();
        
        $recentKonselingUser = Konseling::whereHas('pengaduan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('pengaduan')
        ->latest()
        ->take(3)
        ->get();
        
        $recentPendampinganUser = Pendampingan::whereHas('pengaduan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('pengaduan')
        ->latest()
        ->take(3)
        ->get();
        
        // Monthly trend for user (last 6 months)
        $monthlyTrendUser = Pengaduan::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, DATE_FORMAT(created_at, "%M %Y") as label, count(*) as total')
            ->groupBy('month', 'label')
            ->orderBy('month')
            ->get();
        
        return view('analytics.pelapor', compact(
            'pengaduanUser',
            'totalPengaduanUser',
            'pengaduanMenungguUser',
            'pengaduanDiprosesUser',
            'pengaduanSelesaiUser',
            'totalKonselingUser',
            'totalPendampinganUser',
            // 'recentAssessmentsUser',
            'recentKonselingUser',
            'recentPendampinganUser',
            'monthlyTrendUser'
        ));
    }

    /**
     * Get analytics data for API calls (for AJAX requests)
     */
    public function getAnalyticsData(Request $request)
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
            case 'korban-stats':
                return $this->getKorbanStats($user);
            case 'pelaku-stats':
                return $this->getPelakuStats($user);
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
    
    private function getKorbanStats($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        $korbanStats = $query->with('korban')
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
                    'pendidikan' => $group->groupBy('pendidikan')->map->count(),
                    'status_perkawinan' => $group->groupBy('status_perkawinan')->map->count(),
                ];
            });
            
        return response()->json($korbanStats);
    }
    
    private function getPelakuStats($user)
    {
        $query = Pengaduan::query();
        
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }
        
        $pelakuStats = $query->with('pelaku')
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
                    'pendidikan' => $group->groupBy('pendidikan')->map->count(),
                    'hubungan' => $group->groupBy('hubungan')->map->count(),
                    'kewarganegaraan' => $group->groupBy('kewarganegaraan')->map->count(),
                ];
            });
            
        return response()->json($pelakuStats);
    }
} 