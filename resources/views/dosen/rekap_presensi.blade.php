@extends('components.layout', ['title' => 'Rekap Kehadiran'])

@section('content')
<div class="p-6">
        <!-- Button kembali -->
        <div class="flex items-center mb-4">
        <a href="{{ route('dosen.presensi', ) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>
    
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Rekap Kehadiran Mata Kuliah: {{ $matkul->nama_matkul }}</h1>

    <!-- Legend -->
    <div class="mb-4 flex items-center space-x-4">
        <div class="flex items-center">
            <span class="inline-block w-6 h-6 bg-green-500 text-white text-center rounded mr-2">H</span>
            <span>Hadir</span>
        </div>
        <div class="flex items-center">
            <span class="inline-block w-6 h-6 bg-red-500 text-white text-center rounded mr-2">A</span>
            <span>Alpa</span>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">Kode Mata Kuliah</p>
                <p class="font-medium">{{ $matkul->kode }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">SKS</p>
                <p class="font-medium">{{ $matkul->sks }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Dosen Pengampu</p>
                <p class="font-medium">{{ $matkul->dosen->user->name }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">NIM</th>
                        <th class="border px-4 py-2">Nama Mahasiswa</th>
                        @for($i = 1; $i <= 16; $i++)
                            <th class="border px-2 py-2 text-center">P{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($matkul->mahasiswas as $index => $mahasiswa)
                    <tr>
                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $mahasiswa->nim }}</td>
                        <td class="border px-4 py-2">{{ $mahasiswa->user->name }}</td>
                        @foreach($presences as $presence)
                            <td class="border px-2 py-2 text-center">
                                @if($presence->attendances->where('mahasiswa_id', $mahasiswa->id)->count() > 0)
                                    <span class="text-green-600 font-bold">H</span>
                                @else
                                    <span class="text-red-600 font-bold">A</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rest of your view remains the same -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pertemuan</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Pertemuan</th>
                        <th class="border px-4 py-2">Tanggal</th>
                        <th class="border px-4 py-2">Topik</th>
                        <th class="border px-4 py-2">Hadir</th>
                        <th class="border px-4 py-2">Tidak Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presences as $presence)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $presence->pertemuan_ke }}</td>
                        <td class="border px-4 py-2">{{ $presence->tanggal->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">{{ $presence->topik }}</td>
                        <td class="border px-4 py-2 text-center">{{ $presence->attendances_count }}</td>
                        <td class="border px-4 py-2 text-center">{{ $matkul->mahasiswas->count() - $presence->attendances_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('dosen.presensi.rekap.pdf', $matkul->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
            Download Rekap PDF
        </a>
    </div>
</div>
@endsection