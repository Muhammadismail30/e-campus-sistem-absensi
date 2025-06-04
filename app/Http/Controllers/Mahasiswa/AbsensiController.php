<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Attendance;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AbsensiController extends Controller
{
    public function scanBarcode($token)
    {
        Log::info('======== SCAN ATTEMPT STARTED ========');
        Log::info('Token:', ['token' => $token]);
        Log::info('User:', ['user_id' => Auth::id(), 'email' => Auth::user()->email]);

        try {
            $user = Auth::user();
            if (!$user) {
                Log::error('USER NOT AUTHENTICATED');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Log::info('Checking mahasiswa data...');
            $mahasiswa = $user->mahasiswa;
            if (!$mahasiswa) {
                Log::error('MAHASISWA RECORD NOT FOUND FOR USER', ['user_id' => $user->id]);
                return response()->json(['error' => 'Data mahasiswa tidak valid'], 404);
            }

            Log::info('Checking presence...');
            $presence = Presence::with('mataKuliah')
                ->where('barcode_token', $token)
                ->where('is_active', true)
                ->first();

            if (!$presence) {
                Log::error('PRESENCE NOT FOUND OR INACTIVE', ['token' => $token]);
                return response()->json(['error' => 'Sesi absensi tidak valid'], 404);
            }

            Log::info('Checking enrollment...');
            $isEnrolled = $mahasiswa->mataKuliahs()
                ->where('mata_kuliah.id', $presence->matkul_id)
                ->exists();

            if (!$isEnrolled) {
                Log::error('MAHASISWA NOT ENROLLED', [
                    'mahasiswa_id' => $mahasiswa->id,
                    'matkul_id' => $presence->matkul_id
                ]);
                return response()->json(['error' => 'Anda tidak terdaftar di mata kuliah ini'], 403);
            }

            Log::info('Checking duplicate attendance...');
            $alreadyAttended = Attendance::where([
                ['mahasiswa_id', $mahasiswa->id],
                ['presence_id', $presence->id]
            ])->exists();

            if ($alreadyAttended) {
                return response()->json(['error' => 'Anda sudah absen'], 400);
            }

            Log::info('Recording attendance...');
            $attendance = Attendance::create([
                'mahasiswa_id' => $mahasiswa->id,
                'presence_id' => $presence->id,
                'waktu_absen' => now(),
                'status' => 'Hadir'
            ]);

            Log::info('ATTENDANCE RECORDED', ['attendance_id' => $attendance->id]);

            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $mahasiswa->user->name,
                    'nim' => $mahasiswa->nim,
                    'waktu' => now()->format('d-m-Y H:i:s'),
                    'matkul' => $presence->mataKuliah->nama,
                    'pertemuan' => $presence->pertemuan_ke,
                    'status' => 'hadir'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('SCAN ERROR', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }
}