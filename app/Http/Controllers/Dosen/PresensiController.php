<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah yang diampu oleh dosen (halaman utama presensi).
     */
    public function index()
    {
        $dosenId = Auth::user()->dosen->id;
        $matkuls = MataKuliah::where('dosen_id', $dosenId)->get();

        return view('dosen.presensi', [
            'title' => 'Presensi',
            'active' => 'presensi',
            'matkuls' => $matkuls,
        ]);
    }

    /**
     * Menampilkan daftar mahasiswa yang terdaftar di mata kuliah tertentu.
     */
    public function mahasiswa(MataKuliah $matkul)
    {
        // Ambil data mahasiswa yang terdaftar di mata kuliah ini
        $mahasiswas = $matkul->mahasiswas;

        return view('dosen.presensi-mahasiswa', [
            'title' => 'Daftar Mahasiswa',
            'mahasiswas' => $mahasiswas,
            'matkul' => $matkul,
        ]);
    }
}
