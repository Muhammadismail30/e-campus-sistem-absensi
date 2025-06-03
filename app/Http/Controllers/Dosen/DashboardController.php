<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenId = Auth::user()->dosen->id;
        
        // Ambil data mata kuliah yang diajar
        $matkuls = MataKuliah::where('dosen_id', $dosenId)
                    ->withCount(['presences', 'mahasiswas'])
                    ->get();
        
        // Ambil data presensi hari ini
        $presensiHariIni = Presence::whereHas('mataKuliah', function($q) use ($dosenId) {
                        $q->where('dosen_id', $dosenId);
                    })
                    ->whereDate('tanggal', today())
                    ->orderBy('tanggal', 'desc')
                    ->get();
        
        return view('dosen.dashboard', [
            'matkuls' => $matkuls,
            'presensiHariIni' => $presensiHariIni,
            'totalMatkul' => $matkuls->count(),
            'totalMahasiswa' => $matkuls->sum('mahasiswas_count'),
            'totalPertemuan' => $matkuls->sum('presences_count')
        ]);
    }
}