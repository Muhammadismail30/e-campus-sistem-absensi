<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matkuls = MataKuliah::all();

        return view('mahasiswa.matakuliah', [
            'title' => 'Mata Kuliah Mahasiswa',
            'active' => 'mata kuliah',
            'matkuls' => $matkuls,
        ]);
    }

    public function show(MataKuliah $matkul)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $isEnrolled = $mahasiswa->mataKuliahs()->where('matkul_id', $matkul->id)->exists();

        // Ambil sesi absensi yang aktif untuk mata kuliah ini
        $activeAbsensi = Presence::where('matkul_id', $matkul->id)
            ->where('is_active', true)
            ->first();

        // Ambil semua sesi absensi untuk mata kuliah ini
        $absensis = Presence::where('matkul_id', $matkul->id)->get();

        // Hitung statistik kehadiran
        $totalSesi = $absensis->count();
        $hadir = Attendance::where('mahasiswa_id', $mahasiswa->id)
            ->whereIn('presence_id', $absensis->pluck('id'))
            ->count();

        return view('mahasiswa.enter-matakuliah', [
            'matkul' => $matkul,
            'isEnrolled' => $isEnrolled,
            'activeAbsensi' => $activeAbsensi,
            'totalSesi' => $totalSesi,
            'hadir' => $hadir,
        ]);
    }

    public function confirmRegistration(Request $request, $matkulId)
    {
        $matkul = MataKuliah::findOrFail($matkulId);
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $kodeMatkul = $request->input('kodeMatkul');

        if ($kodeMatkul === $matkul->kode) {
            if (!$mahasiswa->mataKuliahs()->where('matkul_id', $matkulId)->exists()) {
                $mahasiswa->mataKuliahs()->attach($matkulId);
                return redirect()->route('mahasiswa.matakuliah.enter', $matkulId)
                    ->with('success', 'Anda berhasil terdaftar di mata kuliah ini.');
            }
            return redirect()->route('mahasiswa.matakuliah.enter', $matkulId)
                ->with('info', 'Anda sudah terdaftar di mata kuliah ini.');
        }

        return redirect()->back()->with('error', 'Kode matkul salah!');
    }
}