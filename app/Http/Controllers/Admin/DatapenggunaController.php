<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class DatapenggunaController extends Controller
{
    public function index()
    {
        $dosens = User::with('dosen')
            ->where('role', 'dosen')
            ->orderBy('name')
            ->get();

        $mahasiswas = User::with('mahasiswa')
            ->where('role', 'mahasiswa')
            ->orderBy('name')
            ->get();

        return view('admin.datapengguna', [
            'title' => 'Data Pengguna',
            'active' => 'datapengguna',
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas
        ]);
    }
}