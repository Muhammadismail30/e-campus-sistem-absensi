<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    public function index()
    {
        return view('mahasiswa.jadwal', [
            'title' => 'Jadwal Kuliah',
            'active' => 'jadwal',
        ]);
    }
}
