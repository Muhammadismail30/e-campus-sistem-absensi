@extends('components.layout', ['title' => $title ?? 'Daftar Mahasiswa'])

@section('content')
    <div class="p-6">
        <!-- Button kembali -->
        <div class="flex items-center mb-4">
            <a href="{{ route('dosen.presensi') }}"
                class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                Kembali
            </a>
        </div>

        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Mahasiswa Mata Kuliah: {{ $matkul->nama }}</h1>

        <div class="bg-white shadow-lg rounded-lg p-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Mahasiswa Terdaftar</h3>
            <p class="text-sm text-gray-600 mb-6">
                Jumlah mahasiswa:
                {{ $mahasiswas->count() > 0 ? $mahasiswas->count() : 'Tidak ada mahasiswa terdaftar' }}
            </p>

            @if ($mahasiswas->count() > 0)
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 bg-[#DFF5FF]">
                        <thead class="bg-[#577BC1] text-white rounded-t-lg">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">NIM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $index => $mahasiswa)
                                <tr class="transition-all duration-300 ease-in-out hover:bg-[#A7C8E4] cursor-pointer">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $mahasiswa->user->name ?? 'Nama tidak tersedia' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $mahasiswa->nim ?? 'NIM tidak tersedia' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-4 border-t border-gray-200">
                    <div class="px-6 py-8 text-center text-sm text-gray-500">
                        Belum ada mahasiswa yang terdaftar pada mata kuliah ini.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
