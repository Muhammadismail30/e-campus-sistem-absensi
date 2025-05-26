<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;

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
        return view('dosen.manage-matakuliah', compact('matkul'));
    }
}