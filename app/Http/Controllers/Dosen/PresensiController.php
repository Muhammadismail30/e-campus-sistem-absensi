<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Presence;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah yang diampu oleh dosen (halaman utama presensi).
     */
    public function index()
    {
        $dosenId = Auth::user()->dosen->id;
        $matkuls = MataKuliah::where('dosen_id', $dosenId)->get();

        return view('dosen.presensi', [
            'title' => 'Presensi',
            'active' => 'presensi',
            'matkuls' => $matkuls,
        ]);
    }

    /**
     * Menampilkan daftar mahasiswa yang terdaftar di mata kuliah tertentu.
     */
    public function mahasiswa(MataKuliah $matkul)
    {
        // Ambil data mahasiswa yang terdaftar di mata kuliah ini
        $mahasiswas = $matkul->mahasiswas;

        return view('dosen.presensi-mahasiswa', [
            'title' => 'Daftar Mahasiswa',
            'mahasiswas' => $mahasiswas,
            'matkul' => $matkul,
        ]);
    }



### 2. **Atur isi `rekap()` supaya cocok**

    public function rekap($matkulId)
    {
        $matkul = MataKuliah::with(['mahasiswas.user', 'presences' => function($query) {
                        $query->withCount('attendances')
                            ->orderBy('pertemuan_ke');
                    }])
                    ->findOrFail($matkulId);

        // Pastikan ada 16 pertemuan
        $this->ensure16Pertemuan($matkul);

        // Reload to get the updated presences with counts
        $matkul->load(['presences' => function($query) {
            $query->withCount('attendances')
                ->orderBy('pertemuan_ke');
        }]);

        return view('dosen.rekap_presensi', [
            'matkul' => $matkul,
            'presences' => $matkul->presences
        ]);
    }

    public function downloadRekapPdf($matkulId)
    {
        $matkul = MataKuliah::with(['mahasiswas.user', 'presences.attendances.mahasiswa'])
                    ->findOrFail($matkulId);

        // Pastikan ada 16 pertemuan
        $this->ensure16Pertemuan($matkul);

        $pdf = PDF::loadView('dosen.rekap_presensi_pdf', [
            'matkul' => $matkul,
            'presences' => $matkul->presences()->orderBy('pertemuan_ke')->get()
        ]);

        return $pdf->download('rekap-presensi-'.$matkul->kode.'.pdf');
    }

    private function ensure16Pertemuan($matkul)
    {
        $existingPertemuan = $matkul->presences()->pluck('pertemuan_ke')->toArray();
        
        for ($i = 1; $i <= 16; $i++) {
            if (!in_array($i, $existingPertemuan)) {
                Presence::create([
                    'matkul_id' => $matkul->id,
                    'pertemuan_ke' => $i,
                    'topik' => 'Pertemuan ' . $i,
                    'tanggal' => now()->addWeeks($i-1),
                    'is_active' => false,
                    'barcode_token' => Str::random(32)
                ]);
            }
        }
    }


}
