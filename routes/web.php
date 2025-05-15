<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', function () {
    return view('home', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('home');

Route::get('/matakuliah', function () {
    return view('matakuliah', ['title' => 'Mata Kuliah']);
})->middleware(['auth', 'verified'])->name('matakuliah');

Route::get('/jadwal', function () {
    return view('jadwal', ['title' => 'Jadwal']);
})->middleware(['auth', 'verified'])->name('jadwal');

Route::get('/presensi', function () {
    return view('presensi', ['title' => 'Presensi']);
})->middleware(['auth', 'verified'])->name('presensi');
require __DIR__.'/auth.php';
