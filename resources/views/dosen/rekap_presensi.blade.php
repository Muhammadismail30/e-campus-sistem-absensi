@extends('components.layout', ['title' => $title ?? 'Rekap Kehadiran'])

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Rekap Kehadiran Mata Kuliah: {{ $matkul->nama }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Kehadiran Mahasiswa</h3>
            <p class="text-sm text-gray-600 mb-6">
                Jumlah mahasiswa yang hadir: 
                {{ $presences->count() > 0 ? $presences->count() : 'Tidak ada kehadiran' }}
            </p>

            @if($presences->count() > 0)
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 bg-[#DFF5FF]">
                        <thead class="bg-[#577BC1] text-white rounded-t-lg">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presences as $index => $presence)
                                <tr class="transition-all duration-300 ease-in-out hover:bg-[#A7C8E4] cursor-pointer">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $presence->mahasiswa->user->name ?? 'Nama tidak tersedia' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $presence->status ?? 'Belum Dikonfirmasi' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('dosen.presensi.rekap.pdf', $matkul->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                        Download Rekap PDF
                    </a>
                </div>
            @else
                <div class="mt-4 border-t border-gray-200">
                    <div class="px-6 py-8 text-center text-sm text-gray-500">
                        Belum ada mahasiswa yang hadir pada mata kuliah ini.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
