@extends('components.layout', ['title' => $title ?? 'Dashboard'])

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Card Mahasiswa -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-blue-500 text-white mr-4 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Mahasiswa Terdaftar</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_mahasiswa }}</p>
                </div>
            </div>
        </div>

        <!-- Card Dosen -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-green-500 text-white mr-4 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Dosen Terdaftar</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_dosen }}</p>
                </div>
            </div>
        </div>

        <!-- Card Mata Kuliah -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-lg border border-purple-200">
             <a href="{{ route('admin.matakuliah') }}">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-purple-500 text-white mr-4 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-purple-600 mb-1">Mata Kuliah Tersedia</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_matkul }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Mata Kuliah -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Mata Kuliah</h2>
                <p class="text-gray-600">Daftar mata kuliah yang sudah di buat</p>
            </div>
            <a href="{{ route('admin.matakuliah') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Lihat Semua
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if ($matkuls->isNotEmpty())
            <div class="overflow-x-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div class="flex space-x-4 min-w-max">
                    @foreach ($matkuls->take(8) as $matkul)
                        <div
                            class="w-64 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 flex-shrink-0">
                            <a href="{{ route('admin.matakuliah.detail', $matkul->id) }}" class="block">
                                <!-- Header -->
                                <div class="bg-blue-700 p-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h3 class="text-white font-semibold text-base leading-tight truncate">
                                            {{ $matkul->nama }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-4 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-500">Kode</span>
                                        <span class="text-xs font-semibold text-gray-800 bg-gray-100 px-2 py-1 rounded-md">
                                            {{ $matkul->kode }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-500">SKS</span>
                                        <span
                                            class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                            {{ $matkul->sks }} SKS
                                        </span>
                                    </div>

                                    <div class="pt-2 border-t border-gray-100">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-600 truncate">
                                                 {{ $matkul->dosen->user->name ?? 'Belum ditentukan' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Mata Kuliah</h3>
                <p class="text-gray-500">Silakan tambahkan mata kuliah baru untuk memulai.</p>
            </div>
        @endif
    </div>
@endsection
