<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
    $mahasiswaId = Auth::id();

    // Ambil semua presensi yang diikuti mahasiswa
    $presensi = Presence::with(['mataKuliah', 'attendances' => function ($query) use ($mahasiswaId) {
        $query->where('mahasiswa_id', $mahasiswaId);
    }])
    ->whereHas('attendances', function ($query) use ($mahasiswaId) {
        $query->where('mahasiswa_id', $mahasiswaId);
    })
    ->orderByDesc('tanggal')
    ->get();

    // Ambil absensi aktif terbaru
    $activeAbsensi = Presence::where('is_active', true)->latest()->first();

    return view('mahasiswa.presensi', [
        'title' => 'Riwayat Presensi Mahasiswa',
        'presensi' => $presensi,
        'activeAbsensi' => $activeAbsensi, // ← INI YANG PENTING
    ]);
}

}
