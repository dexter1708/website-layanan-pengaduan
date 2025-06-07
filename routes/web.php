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

// Public Routes
Route::get('/', function () {
    return view('welcome');
});


Route::get('/api/kecamatan/{kota_id}', [WilayahController::class, 'getKecamatan']);
Route::get('/api/desa/{kecamatan_id}', [WilayahController::class, 'getDesa']);

// Public view routes (read-only)
Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');

// Assessment routes for all authenticated users
Route::prefix('assessment')->name('assessment.')->group(function () {
    Route::get('/', [AssessmentController::class, 'index'])->name('index');
    Route::get('/{id}', [AssessmentController::class, 'show'])->name('show');
    Route::put('/{id}/konfirmasi', [AssessmentController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
});

// Pendampingan routes for all authenticated users
Route::prefix('pendampingan')->name('pendampingan.')->group(function () {
    Route::get('/', [PendampinganController::class, 'index'])->name('index');
    Route::get('/{id}', [PendampinganController::class, 'show'])->name('show');
    Route::put('/{id}/konfirmasi', [PendampinganController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check() && (Auth::user()->role === 'staff' || Auth::user()->role === 'super_admin')) {
            // Jika pengguna adalah staff atau super admin, arahkan ke dashboard staff
            $controller = new \App\Http\Controllers\DashboardController();
            return $controller->index();
        } else {
            // Untuk pengguna lain, tampilkan dashboard default atau halaman lain
            return view('dashboard'); // Ganti 'dashboard' jika ada view lain untuk non-staff
        }
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengaduan routes
    Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
    Route::get('/status', [PengaduanController::class, 'status'])->name('pengaduan.status');

    // Tracking routes
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/{id}', [TrackingController::class, 'show'])->name('tracking.show');

    // Konseling routes for all authenticated users
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/', [KonselingController::class, 'index'])->name('index');
        Route::get('/{id}', [KonselingController::class, 'show'])->name('show');
        Route::put('/{id}/konfirmasi', [KonselingController::class, 'updateKonfirmasi'])->name('update-konfirmasi');
    });
});

// Staff Routes
Route::middleware(['auth', 'verified', StaffMiddleware::class])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff Konseling Management
    Route::prefix('konseling')->name('konseling.')->group(function () {
        Route::get('/create', [KonselingController::class, 'create'])->name('create');
        Route::post('/', [KonselingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KonselingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KonselingController::class, 'update'])->name('update');
        Route::delete('/{id}', [KonselingController::class, 'destroy'])->name('destroy');
    });

    // Admin Tracking Management
    Route::prefix('tracking')->name('tracking.')->group(function () {
        Route::get('/{id}/edit', [TrackingController::class, 'edit'])->name('edit');
        Route::put('/{id}/status', [TrackingController::class, 'updateStatus'])->name('update-status');
    });

    // Staff Assessment Management
    Route::prefix('assessment')->name('assessment.')->group(function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('index');
        Route::get('/create', [AssessmentController::class, 'create'])->name('create');
        Route::post('/', [AssessmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AssessmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AssessmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [AssessmentController::class, 'destroy'])->name('destroy');
    });

    // Staff Pendampingan Management
    Route::prefix('pendampingan')->name('pendampingan.')->group(function () {
        Route::get('/create', [PendampinganController::class, 'create'])->name('create');
        Route::post('/', [PendampinganController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PendampinganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PendampinganController::class, 'update'])->name('update');
        Route::delete('/{id}', [PendampinganController::class, 'destroy'])->name('destroy');
    });

    // Alamat Management
    Route::prefix('alamat')->name('alamat.')->group(function () {
        Route::get('/', [AlamatController::class, 'index'])->name('index');
        Route::get('/create', [AlamatController::class, 'create'])->name('create');
        Route::post('/', [AlamatController::class, 'store'])->name('store');
        Route::get('/{alamat}/edit', [AlamatController::class, 'edit'])->name('edit');
        Route::put('/{alamat}', [AlamatController::class, 'update'])->name('update');
        Route::delete('/{alamat}', [AlamatController::class, 'destroy'])->name('destroy');
    });

    // Bentuk Kekerasan Management
    Route::prefix('bentuk-kekerasan')->name('bentuk-kekerasan.')->group(function () {
        Route::get('/', [BentukKekerasanController::class, 'index'])->name('index');
        Route::get('/create', [BentukKekerasanController::class, 'create'])->name('create');
        Route::post('/', [BentukKekerasanController::class, 'store'])->name('store');
        Route::get('/{bentukKekerasan}/edit', [BentukKekerasanController::class, 'edit'])->name('edit');
        Route::put('/{bentukKekerasan}', [BentukKekerasanController::class, 'update'])->name('update');
        Route::delete('/{bentukKekerasan}', [BentukKekerasanController::class, 'destroy'])->name('destroy');
    });

    // Pekerjaan Management
    Route::prefix('pekerjaan')->name('pekerjaan.')->group(function () {
        Route::get('/', [PekerjaanController::class, 'index'])->name('index');
        Route::get('/create', [PekerjaanController::class, 'create'])->name('create');
        Route::post('/', [PekerjaanController::class, 'store'])->name('store');
        Route::get('/{pekerjaan}/edit', [PekerjaanController::class, 'edit'])->name('edit');
        Route::put('/{pekerjaan}', [PekerjaanController::class, 'update'])->name('update');
        Route::delete('/{pekerjaan}', [PekerjaanController::class, 'destroy'])->name('destroy');
    });

    // Wilayah Management
    Route::prefix('wilayah')->name('wilayah.')->group(function () {
        Route::get('/', [WilayahController::class, 'index'])->name('index');
        Route::get('/create', [WilayahController::class, 'create'])->name('create');
        Route::post('/', [WilayahController::class, 'store'])->name('store');
        Route::get('/{wilayah}/edit', [WilayahController::class, 'edit'])->name('edit');
        Route::put('/{wilayah}', [WilayahController::class, 'update'])->name('update');
        Route::delete('/{wilayah}', [WilayahController::class, 'destroy'])->name('destroy');
        
        // API endpoints for dynamic dropdowns
        Route::get('/kecamatan/{kotaId}', [WilayahController::class, 'getKecamatan']);
        Route::get('/desa/{kecamatanId}', [WilayahController::class, 'getDesa']);
    });
});

// Super Admin Routes
Route::prefix('management')->middleware(['auth', 'verified', SuperAdminMiddleware::class])->group(function () {
    // Staff management
    Route::get('/staff', [UserManagementController::class, 'staffIndex'])->name('staff.index');
    Route::get('/staff/create', [UserManagementController::class, 'staffCreate'])->name('staff.create');
    Route::post('/staff', [UserManagementController::class, 'staffStore'])->name('staff.store');
    Route::get('/staff/{id}/edit', [UserManagementController::class, 'staffEdit'])->name('staff.edit');
    Route::put('/staff/{id}', [UserManagementController::class, 'staffUpdate'])->name('staff.update');
    Route::delete('/staff/{id}', [UserManagementController::class, 'staffDestroy'])->name('staff.destroy');

    // User/Pelapor management
    Route::get('/users', [UserManagementController::class, 'userIndex'])->name('users.index');
    Route::get('/users/{id}', [UserManagementController::class, 'userShow'])->name('users.show');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'userDestroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
