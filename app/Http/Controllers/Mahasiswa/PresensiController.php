<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    //
    public function index()
    {
        return view('mahasiswa.presensi', [
            'title' => 'Presensi',
            'active' => 'presensi',
        ]);
    }
}
