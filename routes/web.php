<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\PresensiController as MahasiswaPresensiController;
use App\Http\Controllers\Mahasiswa\MataKuliahController as MahasiswaMataKuliahController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PresensiController as DosenPresensiController;
use App\Http\Controllers\Dosen\MataKuliahController as DosenMataKuliahController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// Redirect umum setelah login
Route::get('/dashboard', function() {
    return redirect()->route(auth()->user()->role . '.dashboard');
})->middleware(['auth', 'verified']);

// Route untuk semua role yang terautentikasi
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
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal');
    Route::get('/presensi', [PresensiController::class, 'index'])->name('admin.presensi');
});

// Route khusus dosen
Route::middleware(['auth', 'verified', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/matakuliah', [DosenMataKuliahController::class, 'index'])->name('dosen.matakuliah');
    Route::get('/jadwal', [DosenJadwalController::class, 'index'])->name('dosen.jadwal');
    Route::get('/presensi', [DosenPresensiController::class, 'index'])->name('dosen.presensi');
});

// Route khusus mahasiswa
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/matakuliah', [MahasiswaMataKuliahController::class, 'index'])->name('mahasiswa.matakuliah');
    Route::get('/jadwal', [MahasiswaJadwalController::class, 'index'])->name('mahasiswa.jadwal');
    Route::get('/presensi', [MahasiswaPresensiController::class, 'index'])->name('mahasiswa.presensi');
    
});