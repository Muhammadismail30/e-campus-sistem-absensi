@extends("components.layout", ["title" => $title ?? "Presensi"])

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Presensi</h1>
    </div>

    <!-- Course Cards -->
    <div class="space-y-4">
        @forelse($matkuls as $mk)
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="p-6 text-white">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-2">{{ $mk->nama }}</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                Daftar Mahasiswa
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                Rekap Presensi
                            </span>
                        </div>
                    </div>
                    <div class="text-right text-sm opacity-90">
                        <div class="mb-1">SKS: {{ $mk->sks }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('dosen.presensi.mahasiswa', $mk->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors duration-200">
                        👥 Daftar Mahasiswa
                    </a>
                    <a href="{{ route('dosen.presensi.rekap', $mk->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 border border-white/30 text-white rounded-lg font-medium hover:bg-white/20 transition-colors duration-200">
                        📊 Rekap Presensi
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada mata kuliah yang diampu</h3>
            <p class="text-gray-500">Silakan hubungi admin untuk mendapatkan mata kuliah</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
