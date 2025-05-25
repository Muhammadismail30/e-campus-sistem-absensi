<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    //
    public function index()
    {
        return view('dosen.matakuliah', [
            'title' => 'Mata Kuliah',
            'active' => 'mata kuliah',
        ]);
    }
}
