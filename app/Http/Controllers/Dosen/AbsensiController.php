<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    public function manageMatkul($matkulId)
    {
        $matkul = MataKuliah::findOrFail($matkulId);
        $absensis = Presence::where('matkul_id', $matkulId)->get();

        return view('dosen.manage-matakuliah', [
            'matkul' => $matkul,
            'absensis' => $absensis
        ]);
    }

    public function generateAbsensi($matkulId)
    {
        $matkul = MataKuliah::findOrFail($matkulId);

        // Generate 16 pertemuan
        for ($i = 1; $i <= 16; $i++) {
            Presence::firstOrCreate([
                'matkul_id' => $matkul->id,
                'pertemuan_ke' => $i
            ], [
                'topik' => 'Pertemuan ' . $i,
                'tanggal' => now()->addWeeks($i - 1),
                'is_active' => false,
                'barcode_token' => Str::random(32)
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil digenerate');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'topik' => 'required|string|max:255',
            'tanggal' => 'required|date'
        ]);

        $presence = Presence::findOrFail($id);
        $presence->update([
            'topik' => $validated['topik'],
            'tanggal' => $validated['tanggal']
        ]);

        return redirect()->back()->with('success', 'Data pertemuan berhasil diperbarui');
    }

    public function toggleAbsensi($id)
    {
        $presence = Presence::findOrFail($id);
        $updated = $presence->update([
            'is_active' => !$presence->is_active
        ]);

        return response()->json([
            'status' => $updated,
            'is_active' => !$presence->is_active
        ]);
    }

    public function showBarcode($id)
    {
        $absensi = Presence::with('mataKuliah')->findOrFail($id);

        return view('dosen.barcode', compact('absensi'));
    }

    public function regenerateToken($id)
    {
        $absensi = Presence::findOrFail($id);
        $absensi->update([
            'barcode_token' => Str::random(32),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Token berhasil diperbarui');
    }
}
