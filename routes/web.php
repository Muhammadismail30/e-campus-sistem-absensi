<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('auth.login', ['title' => 'Login']);
});

require __DIR__.'/auth.php';

Route::middleware('auth', 'verified')->group(function () {
    
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    }) ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'] )->name('profile.destroy');
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
    
    Route::get('/admin/matakuliah', [MataKuliahController::class, 'index'])
        ->name('admin.matakuliah');

    Route::post('/admin/matakuliah', [MataKuliahController::class, 'store'])
        ->name('matakuliah.store');
    
    Route::put('/admin/matakuliah/{matkul}', [MataKuliahController::class, 'update'])
        ->name('matakuliah.update');
    
    Route::delete('/admin/matakuliah/{matkul}', [MataKuliahController::class, 'destroy'])
        ->name('matakuliah.destroy');
    

    // Untuk fitur tambahan
});



Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('mahasiswa.dashboard');

Route::get('/dosen/dashboard', [DosenDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dosen.dashboard');

// Route::get('/home', function () {
//     return view('home', ['title' => 'Dashboard']);
// })->middleware(['auth', 'verified'])->name('home');

// Route::get('/matakuliah', function () {
//     return view('matakuliah', ['title' => 'Mata Kuliah']);
// })->middleware(['auth', 'verified'])->name('matakuliah');

// Route::get('/jadwal', function () {
//     return view('jadwal', ['title' => 'Jadwal']);
// })->middleware(['auth', 'verified'])->name('jadwal');

// Route::get('/presensi', function () {
//     return view('presensi', ['title' => 'Presensi']);
// })->middleware(['auth', 'verified'])->name('presensi');
