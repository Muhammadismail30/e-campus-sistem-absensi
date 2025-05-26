@extends("components.layout", ["title" => $matkul->nama])

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $matkul->nama }}</h1>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
            Kode: {{ $matkul->kode }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Materi -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h2 class="text-lg font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Materi
            </h2>
            <ul class="space-y-2">
                @foreach($materi as $item)
                <li>
                    <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        {{ $item->judul }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Absensi -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h2 class="text-lg font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Absensi
            </h2>
            @if($absensi_aktif)
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
                Ada absensi aktif!
                <a href="{{ route('mahasiswa.absensi.isi', $absensi_aktif->id) }}" class="block mt-2">
                    <button class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded">
                        Isi Absensi Sekarang
                    </button>
                </a>
            </div>
            @endif
            <p class="text-sm text-gray-600">Kehadiran: {{ $presensi_count }}/{{ $total_sesi }} sesi</p>
        </div>

        <!-- Tugas -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h2 class="text-lg font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tugas
            </h2>
            <ul class="space-y-2">
                @foreach($tugas as $item)
                <li>
                    <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center justify-between">
                        <span>
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            {{ $item->judul }}
                        </span>
                        @if($item->status == 'selesai')
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Belum</span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection