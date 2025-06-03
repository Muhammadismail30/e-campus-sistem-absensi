@extends("components.layout",["title" => $title ?? "Dashboard Dosen"])
@section('content')
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Dosen</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Card Mata Kuliah -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mata Kuliah Diampu</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalMatkul }}</p>
                </div>
            </div>
        </div>

        <!-- Card Mahasiswa -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</p>
                </div>
            </div>
        </div>

        <!-- Card Pertemuan -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pertemuan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPertemuan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Presensi Hari Ini -->
    <div class="bg-white rounded-lg shadow p-4 mb-6 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Presensi Hari Ini</h2>
        </div>

        @if($presensiHariIni->count() > 0)
            <div class="space-y-3">
                @foreach($presensiHariIni as $presensi)
                <div class="border border-gray-200 p-3 rounded-lg hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $presensi->mataKuliah->nama_matkul }}</h3>
                            <p class="text-sm text-gray-600">Pertemuan {{ $presensi->pertemuan_ke }} - {{ $presensi->topik }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $presensi->tanggal->format('H:i') }}</p>
                        </div>
                        <div>
                            @if($presensi->is_active)
                                <a href="{{ route('dosen.absensi.barcode', $presensi->id) }}" class="px-3 py-1 bg-[#DFF5FF] text-[#18ACFE] text-sm rounded-md border border-[#18ACFE] inline-block">Buka QR</a>
                            @else
                                <form action="{{ route('dosen.absensi.toggle', $presensi->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-md">Aktifkan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Tidak ada jadwal presensi hari ini</p>
        @endif
    </div>

    <!-- Daftar Mata Kuliah -->
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Mata Kuliah Saya</h2>
            <a href="{{ route('dosen.matakuliah') }}" class="text-sm text-[#18ACFE] hover:underline">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($matkuls as $matkul)
            <a href="{{ route('dosen.matakuliah.manage', $matkul->id) }}" class="border border-gray-200 p-3 rounded-lg hover:bg-gray-50">
                <h3 class="font-medium text-gray-800">{{ $matkul->nama_matkul }}</h3>
                <p class="text-sm text-gray-600">{{ $matkul->kelas }} - {{ $matkul->sks }} SKS</p>
                <div class="flex justify-between mt-2">
                    <span class="text-xs text-gray-500">{{ $matkul->presences_count }} pertemuan</span>
                    <span class="text-xs text-gray-500">{{ $matkul->mahasiswas_count }} mahasiswa</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@endsection