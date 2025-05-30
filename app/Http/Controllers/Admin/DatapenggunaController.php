<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'type' => 'required|in:dosen,mahasiswa'
        ]);

        // Generate NIM/NIDN otomatis
        $identifier = $this->generateIdentifier($validated['type']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['type']
        ]);

        if ($validated['type'] === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $identifier
            ]);
        } else {
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $identifier
            ]);
        }

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }

    private function generateIdentifier($type)
    {
        if ($type === 'dosen') {
            $lastDosen = Dosen::orderBy('nidn', 'desc')->first();
            $prefix = 'DSN';
            $lastNumber = $lastDosen ? (int) str_replace($prefix, '', $lastDosen->nidn) : 0;
            $newNumber = $lastNumber + 1;
            return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $lastMahasiswa = Mahasiswa::orderBy('nim', 'desc')->first();
            $prefix = 'MHS';
            $lastNumber = $lastMahasiswa ? (int) str_replace($prefix, '', $lastMahasiswa->nim) : 0;
            $newNumber = $lastNumber + 1;
            return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }
    }
}