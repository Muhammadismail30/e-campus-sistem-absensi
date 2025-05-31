<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function scanBarcode($token)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Cari sesi absensi berdasarkan token
        $presence = Presence::where('barcode_token', $token)
            ->where('is_active', true)
            ->first();

        if (!$presence) {
            return response()->json(['error' => 'Sesi absensi tidak ditemukan atau tidak aktif'], 404);
        }

        // Cek apakah mahasiswa mengikuti matkul tersebut
        $diikuti = $mahasiswa->mataKuliahs()->where('mata_kuliah.id', $presence->matkul_id)->exists();

        if (!$diikuti) {
            return response()->json(['error' => 'Anda tidak terdaftar pada mata kuliah ini'], 403);
        }

        // Cek apakah sudah absen
        $sudahAbsen = Attendance::where('mahasiswa_id', $mahasiswa->id)
            ->where('presence_id', $presence->id)
            ->exists();

        if ($sudahAbsen) {
            return response()->json(['error' => 'Anda sudah melakukan absen'], 400);
        }

        // Catat kehadiran
        Attendance::create([
            'mahasiswa_id' => $mahasiswa->id,
            'presence_id' => $presence->id,
            'waktu_absen' => now()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $mahasiswa->user->name,
                'nim' => $mahasiswa->nim,
                'waktu' => now()->format('d-m-Y H:i:s'),
                'matkul' => $presence->matkul->nama,
                'pertemuan' => $presence->pertemuan_ke
            ]
        ]);
        
    }

    
}
