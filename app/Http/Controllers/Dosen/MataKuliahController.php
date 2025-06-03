<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MataKuliahController extends Controller
{
    public function index()
    {
        $dosenId = Auth::user()->dosen->id;
        $matkuls = MataKuliah::where('dosen_id', $dosenId)->get();
        
        return view('dosen.matakuliah', [
            'matkuls' => $matkuls
        ]);
    }

    public function show(MataKuliah $matkul)
    {
        if ($matkul->dosen_id !== Auth::user()->dosen->id) {
            abort(403, 'Anda tidak memiliki akses ke mata kuliah ini.');
        }

        $absensis = Presence::withCount('attendances')
                    ->where('matkul_id', $matkul->id)
                    ->orderBy('pertemuan_ke', 'asc')
                    ->get();

        $mahasiswas = $matkul->mahasiswas()->with('user')->get();
        $totalMahasiswa = $mahasiswas->count();

        return view('dosen.manage-matakuliah', [
            'matkul' => $matkul,
            'absensis' => $absensis,
            'mahasiswas' => $mahasiswas,
            'totalMahasiswa' => $totalMahasiswa
        ]);
    }
}