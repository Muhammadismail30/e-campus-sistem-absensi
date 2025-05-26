<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Dosen;

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

    public function update(Request $request, Matakuliah $matkul)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode,'.$matkul->id,
            'nama' => 'required',
            'sks' => 'required|numeric',
            'dosen_id' => 'nullable|exists:dosens,id'
        ]);

        $matkul->update($request->all());
        return back()->with('success', 'Mata Kuliah berhasil diupdate');
    }

    public function destroy(Matakuliah $matkul)
    {
        $matkul->delete();
        return back()->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
