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
    Route::post('/datapengguna', [DatapenggunaController::class, 'store'])->name('admin.datapengguna.store');
    Route::delete('/datapengguna/{id}', [DatapenggunaController::class, 'destroy'])->name('admin.datapengguna.delete');
    // Tambahkan alias untuk admin.matakuliah.detail
    Route::get('/matakuliah/{id}', [MataKuliahController::class, 'show'])->name('admin.matakuliah.detail');
    Route::get('/presensi', [PresensiController::class, 'index'])->name('admin.presensi');
    Route::get('/absensi/{id}', [AbsensiController::class, 'show'])->name('admin.absensi.detail');
});

// Route khusus dosen
Route::middleware(['auth', 'verified', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/matakuliah', [DosenMataKuliahController::class, 'index'])->name('dosen.matakuliah');
    Route::get('/matakuliah/{matkul}', [DosenMataKuliahController::class, 'show'])->name('dosen.matakuliah.manage');
    Route::get('/jadwal', [DosenJadwalController::class, 'index'])->name('dosen.jadwal');
    Route::get('/presensi', [DosenPresensiController::class, 'index'])->name('dosen.presensi');
    Route::get('/presensi/{matkul}/mahasiswa', [DosenPresensiController::class, 'mahasiswa'])->name('dosen.presensi.mahasiswa');
    Route::get('/presensi/{matkul}/upload', [DosenPresensiController::class, 'upload'])->name('dosen.presensi.upload');
    Route::get('/presensi/{matkul}/rekap', [DosenPresensiController::class, 'rekap'])->name('dosen.presensi.rekap');
    Route::get('/presensi/{matkulId}/rekap-pdf', [DosenPresensiController::class, 'downloadRekapPdf'])->name('dosen.presensi.rekap.pdf');
    
    // Route sistem absensi
    Route::prefix('absensi')->group(function () {
        Route::post('/generate/{matkul}', [DosenAbsensiController::class, 'generateAbsensi'])->name('dosen.generate.absensi');
        Route::post('/{absensi}/toggle', [DosenAbsensiController::class, 'toggleAbsensi'])->name('dosen.absensi.toggle');
        Route::put('/{id}', [DosenAbsensiController::class, 'update'])->name('dosen.absensi.update'); // Ubah path menjadi /{id}
        Route::get('/{absensi}/barcode', [DosenAbsensiController::class, 'showBarcode'])->name('dosen.absensi.barcode');
        Route::post('/absensi/{id}/regenerate-token', [DosenAbsensiController::class, 'regenerateToken'])->name('dosen.absensi.regenerate-token');
    });
});

// Route khusus mahasiswa
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/matakuliah', [MahasiswaMataKuliahController::class, 'index'])->name('mahasiswa.matakuliah');
    Route::get('/matakuliah/{matkul}', [MahasiswaMataKuliahController::class, 'show'])->name('mahasiswa.matakuliah.enter');
    Route::post('/matakuliah/{matkul}/confirm', [MahasiswaMataKuliahController::class, 'confirmRegistration'])->name('mahasiswa.matakuliah.confirm');
    Route::get('/jadwal', [MahasiswaJadwalController::class, 'index'])->name('mahasiswa.jadwal');
    Route::get('/presensi', [MahasiswaPresensiController::class, 'index'])->name('mahasiswa.presensi');

});


Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Scan barcode untuk absensi
    Route::get('/absensi/scan/{token}', [MahasiswaAbsensiController::class, 'scanBarcode'])->name('mahasiswa.absensi.scan');

    // Form halaman join mata kuliah
    Route::get('/absensi/join', [AbsensiController::class, 'showJoinForm'])->name('mahasiswa.absensi.join.form');

    // Proses join mata kuliah (submit form)
    Route::post('/absensi/join', [AbsensiController::class, 'joinMatkul'])->name('mahasiswa.absensi.join');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
});