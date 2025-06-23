<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PendampinganController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\TrackingController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\BentukKekerasanController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomDashboardController;
use App\Http\Controllers\DataDashboardController;
use App\Http\Controllers\AnalyticsDashboardController;
use App\Http\Controllers\KelolaDataController;
use App\Http\Controllers\KonselingStaffController;

// Public Routes
Route::get('/', function () {
    return view('landing');
});
// Route::get('/Pengaduan', function () {
//     return view('pengaduan.pengaduan');
// });

Route::get('/api/kecamatan/{kota_id}', [WilayahController::class, 'getKecamatan']);
Route::get('/api/desa/{kecamatan_id}', [WilayahController::class, 'getDesa']);

// Public view routes (read-only)
// Assessment feature disabled
// Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');

// --- START: ROUTE UNTUK SEMUA USER TEROTENTIKASI (Staff DAN Pelapor) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/data-dashboard', [DataDashboardController::class, 'index'])->name('data-dashboard.index');
    Route::get('/analytics', [AnalyticsDashboardController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/data', [AnalyticsDashboardController::class, 'getAnalyticsData'])->name('analytics.data');

    // Kelola Data routes
    Route::get('/kelola-data', [KelolaDataController::class, 'index'])->name('kelolaData');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengaduan routes
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
    Route::get('/status', [PengaduanController::class, 'status'])->name('pengaduan.status');

    // Tracking routes
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/{id}', [TrackingController::class, 'show'])->name('tracking.show');

    // --- KONSELING ---
    Route::prefix('konseling')->name('konseling.')->group(function() {
        Route::get('/', [KonselingController::class, 'index'])->name('index');
        
        Route::middleware([\App\Http\Middleware\PelaporOrUserMiddleware::class])->group(function() {
            Route::get('/request', [KonselingController::class, 'requestForm'])->name('request');
            Route::post('/request', [KonselingController::class, 'requestCounseling'])->name('request.store');
        });

        Route::prefix('/{id}')->group(function () {
            Route::get('/', [KonselingController::class, 'show'])->name('show');
            Route::middleware([\App\Http\Middleware\PelaporOrUserMiddleware::class])->group(function() {
                Route::put('/konfirmasi', [KonselingController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
            });
        });
    });

    // --- PENDAMPINGAN ---
    Route::prefix('pendampingan')->name('pendampingan.')->group(function() {
        Route::get('/', [PendampinganController::class, 'index'])->name('index');

        Route::middleware([\App\Http\Middleware\PelaporOrUserMiddleware::class])->group(function() {
            Route::get('/request', [PendampinganController::class, 'requestForm'])->name('request');
            Route::post('/request', [PendampinganController::class, 'requestAccompaniment'])->name('request.store');
        });

        Route::prefix('/{id}')->group(function () {
            Route::get('/', [PendampinganController::class, 'show'])->name('show');
            Route::middleware([\App\Http\Middleware\PelaporOrUserMiddleware::class])->group(function() {
                Route::patch('/konfirmasi', [PendampinganController::class, 'updateKonfirmasi'])->name('konfirmasi.update');
            });
        });
    });
});

// --- START: ROUTE KHUSUS STAFF (menggunakan StaffMiddleware) ---
Route::middleware(['auth', StaffMiddleware::class])->prefix('staff')->name('staff.')->group(function () {
    // Staff Dashboard
    Route::get('/dashboard', [App\Http\Controllers\StaffDashboardController::class, 'index'])->name('dashboard');

    // Staff Pengaduan Management
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/{id}', [PengaduanController::class, 'show'])->name('show');
        Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');
    });

    // Staff Konseling Management
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/', [KonselingController::class, 'index'])->name('index');
        Route::get('/create', [KonselingController::class, 'create'])->name('create');
        Route::post('/', [KonselingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KonselingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KonselingController::class, 'update'])->name('update');
        Route::delete('/{id}', [KonselingController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/konfirmasi', [KonselingController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
    });

    // Admin Tracking Management (Staff bisa mengedit status tracking)
    Route::prefix('tracking')->name('tracking.')->group(function () {
        Route::get('/{id}/edit', [TrackingController::class, 'edit'])->name('edit');
        Route::put('/{id}/status', [TrackingController::class, 'updateStatus'])->name('update-status');
    });

    // Staff Assessment Management - DISABLED
    /*
    Route::prefix('assessment')->name('assessment.')->group(function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('index');
        Route::get('/create', [AssessmentController::class, 'create'])->name('create');
        Route::post('/', [AssessmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AssessmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AssessmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [AssessmentController::class, 'destroy'])->name('destroy');
    });
    */

    // Staff Pendampingan Management (CRUD staff)
    Route::prefix('pendampingan')->name('pendampingan.')->group(function () {
        Route::get('/', [PendampinganController::class, 'index'])->name('index');
        Route::get('/create', [PendampinganController::class, 'create'])->name('create');
        Route::post('/', [PendampinganController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PendampinganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PendampinganController::class, 'update'])->name('update');
        Route::delete('/{id}', [PendampinganController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/konfirmasi', [PendampinganController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
    });

    // ... route staff lainnya seperti Alamat, Bentuk Kekerasan, Pekerjaan, Wilayah ...
    Route::prefix('alamat')->name('alamat.')->group(function () {
        Route::get('/', [AlamatController::class, 'index'])->name('index');
        Route::get('/create', [AlamatController::class, 'create'])->name('create');
        Route::post('/', [AlamatController::class, 'store'])->name('store');
        Route::get('/{alamat}/edit', [AlamatController::class, 'edit'])->name('edit');
        Route::put('/{alamat}', [AlamatController::class, 'update'])->name('update');
        Route::delete('/{alamat}', [AlamatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('bentuk-kekerasan')->name('bentuk-kekerasan.')->group(function () {
        Route::get('/', [BentukKekerasanController::class, 'index'])->name('index');
        Route::get('/create', [BentukKekerasanController::class, 'create'])->name('create');
        Route::post('/', [BentukKekerasanController::class, 'store'])->name('store');
        Route::get('/{bentukKekerasan}/edit', [BentukKekerasanController::class, 'edit'])->name('edit');
        Route::put('/{bentukKekerasan}', [BentukKekerasanController::class, 'update'])->name('update');
        Route::delete('/{bentukKekerasan}', [BentukKekerasanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pekerjaan')->name('pekerjaan.')->group(function () {
        Route::get('/', [PekerjaanController::class, 'index'])->name('index');
        Route::get('/create', [PekerjaanController::class, 'create'])->name('create');
        Route::post('/', [PekerjaanController::class, 'store'])->name('store');
        Route::get('/{pekerjaan}/edit', [PekerjaanController::class, 'edit'])->name('edit');
        Route::put('/{pekerjaan}', [PekerjaanController::class, 'update'])->name('update');
        Route::delete('/{pekerjaan}', [PekerjaanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('wilayah')->name('wilayah.')->group(function () {
        Route::get('/', [WilayahController::class, 'index'])->name('index');
        Route::get('/create', [WilayahController::class, 'create'])->name('create');
        Route::post('/', [WilayahController::class, 'store'])->name('store');
        Route::get('/{type}/{id}/edit', [WilayahController::class, 'edit'])->name('edit');
        Route::put('/{type}/{id}', [WilayahController::class, 'update'])->name('update');
        Route::delete('/{type}/{id}', [WilayahController::class, 'destroy'])->name('destroy');

        Route::get('/kecamatan/{kotaId}', [WilayahController::class, 'getKecamatan']);
        Route::get('/desa/{kecamatanId}', [WilayahController::class, 'getDesa']);
        Route::get('/get-kecamatan/{kotaId}', [WilayahController::class, 'getKecamatan'])->name('get-kecamatan');
    });

    // Instruktur Management
    Route::resource('instruktur', \App\Http\Controllers\InstrukturController::class);

    // Layanan Management
    Route::resource('layanan', \App\Http\Controllers\LayananController::class);
});

// Super Admin Routes (hanya dashboard dan kelola staff)
Route::prefix('admin')->middleware(['auth', SuperAdminMiddleware::class])->name('admin.')->group(function () {
    // Super Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Staff Management (hanya untuk super admin)
    Route::get('/staff', [UserManagementController::class, 'staffIndex'])->name('staff.index');
    Route::get('/staff/create', [UserManagementController::class, 'staffCreate'])->name('staff.create');
    Route::post('/staff', [UserManagementController::class, 'staffStore'])->name('staff.store');
    Route::get('/staff/{id}/edit', [UserManagementController::class, 'staffEdit'])->name('staff.edit');
    Route::put('/staff/{id}', [UserManagementController::class, 'staffUpdate'])->name('staff.update');
    Route::delete('/staff/{id}', [UserManagementController::class, 'staffDestroy'])->name('staff.destroy');
});

require __DIR__.'/auth.php';
