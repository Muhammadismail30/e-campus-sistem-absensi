@extends("components.layout", ["title" => "Manajemen Kelas"])

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header Mata Kuliah -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $matkul->nama }}</h1>
            <p class="mt-1 text-sm text-gray-600">Kode Mata Kuliah: {{ $matkul->kode }}</p>
        </div>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
            Semester {{ $matkul->semester ?? 'N/A' }} - {{ $matkul->tahun_akademik ?? '2024/2025' }}
        </span>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px">
            <li>
                <button class="inline-block p-4 border-b-2 border-blue-600 text-blue-600 font-semibold text-sm">
                    Daftar Absensi
                </button>
            </li>
        </ul>
    </div>

    <!-- Area Absensi -->
    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-5 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Sesi Absensi</h3>
            <button class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Absensi Baru
            </button>
        </div>
        <div class="border-t border-gray-200">
            <div class="px-6 py-8 text-center text-sm text-gray-500">
                Belum ada sesi absensi untuk mata kuliah ini.
            </div>
        </div>
    </div>
</div>
@endsection