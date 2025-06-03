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
        $mahasiswa = Auth::user()->mahasiswa;
        
        // Ambil semua presensi yang diikuti mahasiswa dengan data lengkap
        $presensi = Presence::with([
            'mataKuliah',
            'attendances' => function($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            }
        ])
        ->whereHas('attendances', function($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->id);
        })
        ->orderByDesc('tanggal')
        ->paginate(10); // Pagination untuk data yang banyak

        // Hitung statistik kehadiran
        $totalHadir = Attendance::where('mahasiswa_id', $mahasiswa->id)
                        ->where('status', 'hadir')
                        ->count();
                        
        $totalSesi = $presensi->total();

        return view('mahasiswa.presensi', [
            'title' => 'Riwayat Presensi',
            'presensi' => $presensi,
            'totalHadir' => $totalHadir,
            'totalSesi' => $totalSesi,
            'persentaseKehadiran' => $totalSesi > 0 ? round(($totalHadir/$totalSesi)*100, 2) : 0
        ]);
    }
}