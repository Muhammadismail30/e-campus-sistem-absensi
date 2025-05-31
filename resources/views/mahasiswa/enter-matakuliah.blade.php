@extends('components.layout', ['title' => 'Detail Mata Kuliah: ' . $matkul->nama])

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header Informasi Mata Kuliah --}}
    <div class="mb-8 p-6 bg-sky-700 text-white rounded-xl shadow-xl">
        <h1 class="text-3xl font-bold tracking-tight">{{ $matkul->nama }}</h1>
        <p class="text-lg mt-1 text-sky-200">Kode Mata Kuliah: {{ $matkul->kode }}</p>
        <div class="mt-3 flex flex-wrap gap-2 items-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-sky-100 text-sky-800 shadow">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z"></path></svg>
                {{ $matkul->sks }} SKS
            </span>
            @if($matkul->dosen && $matkul->dosen->user)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-teal-100 text-teal-800 shadow">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    Dosen: {{ $matkul->dosen->user->name }}
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-700 shadow">
                    Dosen: Belum ditentukan
                </span>
            @endif
        </div>
    </div>

    {{-- Grid untuk Konten Utama: Sesi Kelas dan Absensi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        {{-- Kolom Sesi Perkuliahan yang Aktif --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 border-b-2 border-blue-500 pb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Sesi Perkuliahan
            </h2>
            
            @php
                // Cari presence yang sedang aktif untuk hari ini
                $sesiAktif = $matkul->presences()
                    ->where('tanggal', now()->toDateString())
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                // Ambil beberapa sesi terakhir untuk ditampilkan
                $sesiTerbaru = $matkul->presences()
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($sesiAktif)
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-green-800">🟢 Sesi Hari Ini</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            Tersedia
                        </span>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($sesiAktif->tanggal)->format('d M Y') }}</p>
                        <p><span class="font-medium">Waktu Dibuka:</span> {{ $sesiAktif->created_at->format('H:i') }}</p>
                        @if(isset($sesiAktif->keterangan) && $sesiAktif->keterangan)
                            <p><span class="font-medium">Keterangan:</span> {{ $sesiAktif->keterangan }}</p>
                        @endif
                    </div>
                </div>
            @endif
            
            @if($sesiTerbaru->count() > 0)
                <div class="space-y-3">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Riwayat Sesi Terakhir:</h4>
                    @foreach($sesiTerbaru as $sesi)
                        <div class="p-3 bg-gray-50 border-gray-200 rounded-lg border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Dibuka: {{ $sesi->created_at->format('H:i') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    Sesi {{ $loop->iteration }}
                                </span>
                            </div>
                            @if(isset($sesi->keterangan) && $sesi->keterangan)
                                <p class="text-xs text-gray-600 mt-1">{{ $sesi->keterangan }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada sesi perkuliahan</p>
                    <p class="text-gray-400 text-sm mt-1">Dosen belum membuat sesi untuk mata kuliah ini</p>
                </div>
            @endif
        </div>

        {{-- Kolom Absensi --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 border-b-2 border-emerald-500 pb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Absensi & Kehadiran
            </h2>
            
            @php
                // Hitung statistik kehadiran mahasiswa
                $mahasiswa = auth()->user()->mahasiswa ?? null;
                $totalSesi = $matkul->presences()->count();
                $totalKehadiran = 0;
                
                if($mahasiswa && \Schema::hasTable('mahasiswa_presence')) {
                    // Cek apakah tabel mahasiswa_presence ada
                    try {
                        $totalKehadiran = \DB::table('mahasiswa_presence')
                            ->join('presences', 'presences.id', '=', 'mahasiswa_presence.presence_id')
                            ->where('mahasiswa_presence.mahasiswa_id', $mahasiswa->id)
                            ->where('presences.matkul_id', $matkul->id)
                            ->count();
                    } catch (\Exception $e) {
                        $totalKehadiran = 0;
                    }
                }
            @endphp
            
            <div class="space-y-4 text-gray-700">
                @if($sesiAktif)
                    <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                        <p class="text-sm font-medium text-emerald-700">Sesi Absensi Hari Ini:</p>
                        <p class="text-base font-semibold text-emerald-800">Sedang Berlangsung</p>
                        <p class="text-xs text-emerald-600 mt-1">
                            Dibuka: {{ $sesiAktif->created_at->format('H:i') }}
                        </p>
                    </div>
                    
                    @if($mahasiswa)
                        @php
                            // Cek apakah mahasiswa sudah absen untuk sesi ini
                            $sudahAbsen = false;
                            if(\Schema::hasTable('mahasiswa_presence')) {
                                try {
                                    $sudahAbsen = \DB::table('mahasiswa_presence')
                                        ->where('mahasiswa_id', $mahasiswa->id)
                                        ->where('presence_id', $sesiAktif->id)
                                        ->exists();
                                } catch (\Exception $e) {
                                    $sudahAbsen = false;
                                }
                            }
                        @endphp
                        
                        @if($sudahAbsen)
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm text-blue-700 font-medium">✓ Anda sudah melakukan absensi hari ini</p>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('absensi.store') }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="presence_id" value="{{ $sesiAktif->id }}">
                                <input type="hidden" name="matkul_id" value="{{ $matkul->id }}">
                                <button type="submit" class="w-full px-4 py-3 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-opacity-75 transition-colors transform hover:scale-105">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Isi Absensi Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p class="text-sm text-yellow-700">Anda perlu login sebagai mahasiswa untuk melakukan absensi</p>
                        </div>
                    @endif
                @else
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-700">Sesi Absensi Hari Ini:</p>
                        <p class="text-base font-semibold text-gray-800">Belum ada sesi yang aktif</p>
                    </div>
                    <button type="button" class="w-full px-4 py-3 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed" disabled>
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Tidak Ada Sesi Aktif
                    </button>
                @endif
                
                {{-- Statistik Kehadiran --}}
                <div class="p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Statistik Kehadiran Anda:</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $totalKehadiran }}</p>
                            <p class="text-xs text-gray-600">Hadir</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-600">{{ $totalSesi }}</p>
                            <p class="text-xs text-gray-600">Total Sesi</p>
                        </div>
                    </div>
                    @if($totalSesi > 0)
                        <div class="mt-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Persentase Kehadiran</span>
                                <span>{{ round(($totalKehadiran / $totalSesi) * 100, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ ($totalKehadiran / $totalSesi) * 100 }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('styles')
<style>
    .font-mono {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
    
    .transition-shadow {
        transition: box-shadow 0.3s ease-in-out;
    }
    
    .transition-colors {
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush