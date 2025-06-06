<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\Presence;
use Illuminate\Database\QueryException;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matkuls = MataKuliah::with(['dosen.user'])->get();
        $dosens = Dosen::with('user')->get();

        return view('admin.matakuliah', [
            'title' => 'Mata Kuliah',
            'active' => 'matakuliah',
            'matkuls' => $matkuls,
            'dosens' => $dosens
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah',
            'nama' => 'required',
            'sks' => 'required|numeric',
            'dosen_id' => 'nullable|exists:dosens,id'
        ]);

        MataKuliah::create($request->all());
        return back()->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    public function update(Request $request, MataKuliah $matkul)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode,' . $matkul->id,
            'nama' => 'required',
            'sks' => 'required|numeric',
            'dosen_id' => 'nullable|exists:dosens,id'
        ]);

        $matkul->update($request->all());
        return back()->with('success', 'Mata Kuliah berhasil diupdate');
    }

    public function destroy(MataKuliah $matkul)
{
    try {
        $matkul->delete();
        return back()->with('success', 'Mata Kuliah berhasil dihapus');
    } catch (QueryException $e) {
        // Cek jika error karena foreign key constraint
        if ($e->getCode() == '23000') {
            return back()->with('error', 'Anda tidak bisa menghapus kelas yang sudah terisi absensi');
        }

        // Untuk error lain, kembalikan pesan default
        return back()->with('error', 'Terjadi kesalahan saat menghapus Mata Kuliah');
    }
}

    public function show($id)
    {
        $matkul = MataKuliah::with(['dosen', 'presences.attendances'])
                ->withCount('mahasiswas')
                ->findOrFail($id);

        return view('admin.matakuliah-detail', [
            'matkul' => $matkul,
            'presences' => $matkul->presences,
            'mahasiswa_count' => $matkul->mahasiswas_count
        ]);
    }
}