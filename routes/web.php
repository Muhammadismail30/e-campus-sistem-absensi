<?php

// File: routes/web.php

// Import semua controller yang dibutuhkan dari file pertama
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\DatapenggunaController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PresensiController as MahasiswaPresensiController;
use App\Http\Controllers\Mahasiswa\MataKuliahController as MahasiswaMataKuliahController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PresensiController as DosenPresensiController;
use App\Http\Controllers\Dosen\MataKuliahController as DosenMataKuliahController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use App\Http\Controllers\Dosen\AbsensiController as DosenAbsensiController;
use App\Http\Controllers\Mahasiswa\AbsensiController as MahasiswaAbsensiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

 // Diperlukan untuk Auth::user() dan auth()->check()

// Route home - redirect ke dashboard sesuai role jika sudah login, jika belum tampilkan welcome
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        // Pastikan route role.dashboard ada, jika tidak fallback ke /login
        try {
            return redirect()->route($role . '.dashboard');
        } catch (\Exception $e) {
            // Jika role dashboard tidak ditemukan, fallback ke login atau dashboard umum
            // Ini bisa terjadi jika role tidak memiliki dashboard terdefinisi atau ada kesalahan ketik
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'auth' => 'Terjadi kesalahan konfigurasi role'
            ]);
        }
    }
    return redirect()->route('login');// Asumsikan view 'welcome.blade.php' ada
})->name('home');

// Auth routes (misalnya dari Laravel Breeze/Jetstream)
require __DIR__.'/auth.php';


Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    try {
        return redirect()->route(Auth::user()->role . '.dashboard');
    } catch (\Exception $e) {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'auth' => 'Konfigurasi role tidak valid'
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');
// Profile routes - untuk semua role yang terautentikasi dan terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route khusus admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('admin.matakuliah');
    Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
    Route::put('/matakuliah/{matkul}', [MataKuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/{matkul}', [MataKuliahController::class, 'destroy'])->name('matakuliah.destroy');
    Route::get('/datapengguna', [DatapenggunaController::class, 'index'])->name('admin.datapengguna');
    Route::get('/matakuliah/{id}', [MataKuliahController::class, 'show'])->name('admin.matakuliah.detail');
    Route::get('/presensi', [PresensiController::class, 'index'])->name('admin.presensi');
    Route::get('/absensi/{presence}', [AbsensiController::class, 'show'])
         ->name('admin.absensi.detail');
});

// Route khusus dosen
Route::middleware(['auth', 'verified', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/matakuliah', [DosenMataKuliahController::class, 'index'])->name('dosen.matakuliah');
    Route::get('/matakuliah/{matkul}/manage', [DosenAbsensiController::class, 'manageMatkul'])->name('dosen.matakuliah.manage');
    Route::get('/jadwal', [DosenJadwalController::class, 'index'])->name('dosen.jadwal');
    Route::get('/presensi', [DosenPresensiController::class, 'index'])->name('dosen.presensi');
    
    // Route sistem absensi
    Route::prefix('absensi')->group(function () {
        Route::post('/generate/{matkul}', [DosenAbsensiController::class, 'generateAbsensi'])->name('dosen.generate.absensi');
        Route::post('/{absensi}/toggle', [DosenAbsensiController::class, 'toggleAbsensi'])->name('dosen.absensi.toggle');
        Route::put('/{id}', [DosenAbsensiController::class, 'update'])->name('dosen.absensi.update'); // Ubah path menjadi /{id}
        Route::get('/{absensi}/barcode', [DosenAbsensiController::class, 'showBarcode'])->name('dosen.absensi.barcode');
    });
});

// Route khusus mahasiswa
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/matakuliah', [MahasiswaMataKuliahController::class, 'index'])->name('mahasiswa.matakuliah');
    Route::get('/matakuliah/{id}/enter', [MahasiswaMataKuliahController::class, 'show'])->name('mahasiswa.matakuliah.enter');
    Route::get('/jadwal', [MahasiswaJadwalController::class, 'index'])->name('mahasiswa.jadwal');
    Route::get('/presensi', [MahasiswaPresensiController::class, 'index'])->name('mahasiswa.presensi');
    
    // Tambahan route untuk scan barcode
    Route::get('/scan/{token}', [MahasiswaAbsensiController::class, 'scanBarcode'])
         ->name('mahasiswa.scan.absensi');

});