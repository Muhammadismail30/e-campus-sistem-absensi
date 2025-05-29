<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request; // Tidak digunakan jika tidak ada input request yang diproses
use App\Models\MataKuliah;
// use Illuminate\Support\Facades\Auth; // Tidak digunakan lagi setelah penyederhanaan

class MataKuliahController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah yang tersedia untuk mahasiswa.
     */
    public function index()
    {
        $matkuls = MataKuliah::all();

        return view('mahasiswa.matakuliah', [
            'title' => 'Mata Kuliah Mahasiswa',
            'active' => 'mata kuliah',
            'matkuls' => $matkuls,
        ]);
    }

    /**
     * Menampilkan halaman detail mata kuliah untuk mahasiswa.
     * Hanya meneruskan objek $matkul ke view.
     *
     * @param  \App\Models\MataKuliah  $matkul
     * @return \Illuminate\View\View
     */
    public function show(MataKuliah $matkul) // Menggunakan Route-Model Binding
    {
        // Langsung meneruskan objek $matkul yang sudah di-resolve oleh Laravel
        // ke view 'mahasiswa.enter-matakuliah'.
        // Tidak ada lagi pengambilan data materi, tugas, atau absensi di sini.
        return view('mahasiswa.enter-matakuliah', [
            'matkul' => $matkul,
        ]);
    }
}