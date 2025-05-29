@extends("components.layout", ["title" => "Detail Absensi"])

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Absensi</h1>
            <div class="mt-1 flex flex-wrap items-center gap-4">
                <p class="text-sm text-gray-600">Mata Kuliah: {{ $matkul->nama }}</p>
                <p class="text-sm text-gray-600">Pertemuan: {{ $presence->pertemuan_ke }}</p>
                <p class="text-sm text-gray-600">Tanggal: {{ $presence->tanggal->format('d M Y H:i') }}</p>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $presence->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            {{ $presence->is_active ? 'Aktif' : 'Nonaktif' }}
        </span>
    </div>

    <!-- Daftar Mahasiswa -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Kehadiran Mahasiswa</h3>
        </div>

        @if($presence->attendances->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Absen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($presence->attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->mahasiswa->nim }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->mahasiswa->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->waktu_absen->format('d M Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Hadir
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-8 text-center text-sm text-gray-500">
            Belum ada mahasiswa yang hadir pada pertemuan ini.
        </div>
        @endif
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="{{ route('admin.matakuliah.detail', $matkul->id) }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Detail Mata Kuliah
        </a>
    </div>
</div>
@endsection