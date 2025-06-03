<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;

class AbsensiController extends Controller
{
    public function show($id)
    {
        $presence = Presence::with(['mataKuliah', 'attendances.mahasiswa.user'])
                    ->findOrFail($id);

        return view('admin.absensi-detail', [
            'presence' => $presence,
        ]);
    }
}