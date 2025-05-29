<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // app/Http/Controllers/Mahasiswa/AbsensiController.php
public function scanBarcode($token)
    {
        $absensi = Presence::where('barcode_token', $token)
                    ->where('is_active', true)
                    ->firstOrFail();
        
        $mahasiswa = Auth::user()->mahasiswa;
        
        // Cek apakah sudah absen
        if (Attendance::where('mahasiswa_id', $mahasiswa->id)
                    ->where('presence_id', $absensi->id)
                    ->exists()) {
            return response()->json(['error' => 'Anda sudah melakukan absen'], 400);
        }
        
        // Catat kehadiran
        Attendance::create([
            'mahasiswa_id' => $mahasiswa->id,
            'presence_id' => $absensi->id,
            'waktu_absen' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $mahasiswa->user->name,
                'nim' => $mahasiswa->nim,
                'waktu' => now()->format('d-m-Y H:i:s'),
                'matkul' => $absensi->matkul->nama,
                'pertemuan' => $absensi->pertemuan_ke
            ]
        ]);
    }
}