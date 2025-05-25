<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    public function index()
    {
        return view('dosen.jadwal', [
            'title' => 'Jadwal Kuliah',
            'active' => 'jadwal',
        ]);
    }
}
