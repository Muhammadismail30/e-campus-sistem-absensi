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
        // Dapatkan model mahasiswa yang terkait dengan user
        $mahasiswa = Auth::user()->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Ambil semua presensi yang diikuti mahasiswa
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
        ->get();

        return view('mahasiswa.presensi', [
            'title' => 'Riwayat Presensi Mahasiswa',
            'presensi' => $presensi,
        ]);
    }
}