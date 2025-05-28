<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    //
    public function index()
{
    $matkuls = MataKuliah::all(); // ambil semua mata kuliah langsung dari tabel

    return view('mahasiswa.matakuliah', [
        'title' => 'Mata Kuliah Mahasiswa',
        'active' => 'mata kuliah',
        'matkuls' => $matkuls,
    ]);
}

    public function enter($id)
    {
        $matkul = MataKuliah::with(['materi', 'tugas', 'absensi'])->findOrFail($id);
        $absensi_aktif = $matkul->absensi()->where('status', 'aktif')->first();
        $presensi_count = Auth::user()->mahasiswa->presensi()->whereIn('absensi_id', $matkul->absensi->pluck('id'))->count();
        $total_sesi = $matkul->absensi->count();
        
        return view('mahasiswa.enter-matakuliah', [
            'matkul' => $matkul,
            'materi' => $matkul->materi,
            'tugas' => $matkul->tugas,
            'absensi_aktif' => $absensi_aktif,
            'presensi_count' => $presensi_count,
            'total_sesi' => $total_sesi
        ]);
    }
}
