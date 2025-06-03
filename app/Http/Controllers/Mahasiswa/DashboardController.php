<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['mataKuliahs.presences', 'user'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $totalMatkul = $mahasiswa->mataKuliahs->count();
        
        // Hitung kehadiran per mata kuliah
        $matkulWithPresence = [];
        $totalHadirAll = 0;
        $totalSesiAll = 0;
        
        foreach ($mahasiswa->mataKuliahs as $matkul) {
            // Pastikan hanya menghitung maksimal 16 pertemuan
            $totalSesiMatkul = min($matkul->presences->count(), 16);
            $hadirMatkul = Attendance::where('mahasiswa_id', $mahasiswa->id)
                              ->whereIn('presence_id', $matkul->presences->pluck('id'))
                              ->count();
            
            // Pastikan tidak melebihi 16 pertemuan
            $hadirMatkul = min($hadirMatkul, 16);
            $persentase = $totalSesiMatkul > 0 ? round(($hadirMatkul/$totalSesiMatkul)*100, 2) : 0;
            
            $matkulWithPresence[] = [
                'matkul' => $matkul,
                'totalSesi' => $totalSesiMatkul,
                'hadir' => $hadirMatkul,
                'persentase' => $persentase
            ];
            
            $totalHadirAll += $hadirMatkul;
            $totalSesiAll += $totalSesiMatkul;
        }

        // Hitung persentase keseluruhan
        $persentaseKehadiran = $totalSesiAll > 0 ? round(($totalHadirAll/$totalSesiAll)*100, 2) : 0;

        // Jadwal hari ini
        $todaySchedules = Presence::with('mataKuliah')
                            ->whereIn('matkul_id', $mahasiswa->mataKuliahs->pluck('id'))
                            ->whereDate('tanggal', today())
                            ->get();

        return view('mahasiswa.dashboard', [
            'title' => 'Dashboard Mahasiswa',
            'active' => 'dashboard',
            'mahasiswa' => $mahasiswa,
            'totalMatkul' => $totalMatkul,
            'totalHadir' => $totalHadirAll,
            'totalSesi' => $totalSesiAll,
            'persentaseKehadiran' => $persentaseKehadiran,
            'matkulWithPresence' => $matkulWithPresence,
            'todaySchedules' => $todaySchedules
        ]);
    }
}