<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    //
    public function index()
    {
        return view('mahasiswa.matakuliah', [
            'title' => 'Mata Kuliah',
            'active' => 'mata kuliah',
        ]);
    }
}
