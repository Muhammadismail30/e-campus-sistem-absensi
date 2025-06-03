<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        $mahasiswaId = Auth::id(); 


        $presensi = Presence::with(['mata_Kuliah', 'attendances' => function ($query) use ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId);
        }])
        ->whereHas('attendances', function ($query) use ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId);
        })
        ->orderByDesc('updated_at')
        ->get();

        return view('mahasiswa.presensi', [
            'title' => 'Riwayat Presensi',
            'presensi' => $presensi,
        ]);
    }
}
