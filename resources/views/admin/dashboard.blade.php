@extends("components.layout",["title" => $title ?? "Dashboard"])

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Card Mahasiswa -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mahasiswa Terdaftar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_mahasiswa }}</p>
                </div>
            </div>
        </div>

        <!-- Card Dosen -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dosen Terdaftar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_dosen }}</p>
                </div>
            </div>
        </div>

        <!-- Card Mata Kuliah -->
        <div class="bg-[#DFF5FF] p-4 rounded-lg shadow border border-[#18ACFE]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#18ACFE] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mata Kuliah Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total_matkul }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
