<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'active' => 'dashboard',
            'total_mahasiswa' => Mahasiswa::count(),
            'total_dosen' => Dosen::count(),
            'total_matkul' => MataKuliah::count()
        ]);
    }
}
