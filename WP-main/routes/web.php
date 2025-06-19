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
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/data-dashboard', [DataDashboardController::class, 'index'])->name('data-dashboard.index');
    Route::get('/analytics', [AnalyticsDashboardController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/data', [AnalyticsDashboardController::class, 'getAnalyticsData'])->name('analytics.data');

    // Kelola Data routes
    Route::get('/kelola-data', [KelolaDataController::class, 'index'])->name('kelolaData');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengaduan routes (misal: user create, staff list all)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
    Route::get('/status', [PengaduanController::class, 'status'])->name('pengaduan.status');

    // Tracking routes
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/{id}', [TrackingController::class, 'show'])->name('tracking.show');

    // Konseling routes (index dan show, dapat diakses umum)
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/', [KonselingController::class, 'index'])->name('index');
        Route::get('/create', [KonselingController::class, 'create'])->name('create');
        Route::get('/{id}', [KonselingController::class, 'show'])->name('show');
        Route::get('/konfirmasi/{id}', [KonselingController::class, 'showkonfirmasi'])->name('showkonfirmasi');
        Route::put('/{id}/konfirmasi', [KonselingController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
    });

    // Pendampingan Routes - index dan show (UMUM)
    Route::prefix('pendampingan')->name('pendampingan.')->group(function () {
        Route::get('/', [PendampinganController::class, 'index'])->name('index');
        Route::get('/create', [PendampinganController::class, 'create'])->name('create');
        Route::get('/{id}', [PendampinganController::class, 'show'])->name('show');
        Route::get('/konfirmasi/{id}', [PendampinganController::class, 'showkonfirmasi'])->name('showkonfirmasi');
        Route::put('/{id}/konfirmasi', [PendampinganController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
    });

    // User Pendampingan Request Routes (KHUSUS USER/PELAPOR)
    Route::prefix('user')->name('user.')->group(function () {
        Route::prefix('pendampingan')->name('pendampingan.')->group(function () {
            Route::get('/request', [PendampinganController::class, 'requestForm'])->name('request');
            Route::post('/request', [PendampinganController::class, 'requestAccompaniment'])->name('request');
        });

        // User Konseling Request Routes (KHUSUS USER/PELAPOR)
        Route::prefix('konseling')->name('konseling.')->group(function () {
            Route::get('/request', [KonselingController::class, 'requestForm'])->name('request');
            Route::post('/request', [KonselingController::class, 'requestCounseling'])->name('request');
        });
    });
});

// --- START: ROUTE KHUSUS STAFF (menggunakan StaffMiddleware) ---
Route::middleware(['auth', 'verified', StaffMiddleware::class])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff Konseling Management
    Route::prefix('konseling')->name('konseling.')->group(function () {
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
    });

    // Instruktur Management
    Route::resource('instruktur', \App\Http\Controllers\InstrukturController::class);

    // Layanan Management
    Route::resource('layanan', \App\Http\Controllers\LayananController::class);
});

// Super Admin Routes (tetap sama)
Route::prefix('management')->middleware(['auth', 'verified', SuperAdminMiddleware::class])->group(function () {
    // ... staff management, user management ...
    Route::get('/staff', [UserManagementController::class, 'staffIndex'])->name('staff.index');
    Route::get('/staff/create', [UserManagementController::class, 'staffCreate'])->name('staff.create');
    Route::post('/staff', [UserManagementController::class, 'staffStore'])->name('staff.store');
    Route::get('/staff/{id}/edit', [UserManagementController::class, 'staffEdit'])->name('staff.edit');
    Route::put('/staff/{id}', [UserManagementController::class, 'staffUpdate'])->name('staff.update');
    Route::delete('/staff/{id}', [UserManagementController::class, 'staffDestroy'])->name('staff.destroy');

    Route::get('/users', [UserManagementController::class, 'userIndex'])->name('users.index');
    Route::get('/users/{id}', [UserManagementController::class, 'userShow'])->name('users.show');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'userDestroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
