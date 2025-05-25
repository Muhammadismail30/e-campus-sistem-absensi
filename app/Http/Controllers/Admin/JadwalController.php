<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    public function index()
    {
        return view('admin.jadwal', [
            'title' => 'Jadwal Kuliah',
            'active' => 'jadwal',
        ]);
    }
}
