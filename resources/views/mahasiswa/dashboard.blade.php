@extends("components.layout",["title" => $title ?? "Dashboard Mahasiswa"])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Mahasiswa</h1>
    <p class="text-gray-600">Selamat datang, {{ $mahasiswa->user->name }}</p>
</div>

<!-- Card stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Card Mata Kuliah -->
    <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-100 p-4">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Mata Kuliah Diambil</p>
                <p class="text-2xl font-bold">{{ $totalMatkul }} Mata Kuliah</p>
                <p class="text-sm text-gray-500"></p>
            </div>
        </div>
    </div>

    <!-- Card Kehadiran -->
    <div class="bg-green-50 rounded-lg shadow-sm border border-green-100 p-4">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Kehadiran</p>
                <p class="text-2xl font-bold">{{ $totalHadir }} / {{ $totalSesi }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $persentaseKehadiran }}% dari total sesi</p>
            </div>
        </div>
    </div>

    <!-- Card Status -->
    <div class="bg-purple-50 rounded-lg shadow-sm border border-purple-100 p-4">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Akademik</p>
                <p class="text-2xl font-bold">
                    {{ $persentaseKehadiran >= 80 ? 'Aktif' : 'Perlu Perhatian' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $persentaseKehadiran >= 80 ? 'Kehadiran memenuhi syarat' : 'Kehadiran di bawah 80%' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Mata Kuliah -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-800">Mata Kuliah Saya</h2>
        <a href="{{ route('mahasiswa.matakuliah') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
    </div>

    @if($mahasiswa->mataKuliahs->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($matkulWithPresence as $item)
        <a href="{{ route('mahasiswa.matakuliah.enter', $item['matkul']->id) }}" 
           class="border border-gray-200 p-3 rounded-lg hover:bg-gray-50">
            <h3 class="font-medium text-gray-800">{{ $item['matkul']->nama }}</h3>
            <p class="text-sm text-gray-600">{{ $item['matkul']->kode }} - {{ $item['matkul']->sks }} SKS</p>
            
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" 
                         style="width: {{ $item['persentase'] }}%"></div>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">{{ $item['hadir'] }} / {{ $item['totalSesi'] }} pertemuan</span>
                    <span class="text-xs text-gray-500">{{ $item['persentase'] }}%</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-4 text-gray-500">
        Anda belum mengambil mata kuliah apapun.
        <a href="{{ route('mahasiswa.matakuliah') }}" class="text-blue-600 hover:underline">Daftar mata kuliah</a>
    </div>
    @endif
</div>

<!-- Jadwal Hari Ini -->
<div class="bg-white rounded-lg shadow p-4">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Jadwal Hari Ini</h2>
    
    @if($todaySchedules->count() > 0)
    <div class="space-y-3">
        @foreach($todaySchedules as $schedule)
        <div class="border border-gray-200 p-3 rounded-lg hover:bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-medium text-gray-800">{{ $schedule->mataKuliah->nama }}</h3>
                    <p class="text-sm text-gray-600">Pertemuan {{ $schedule->pertemuan_ke }}: {{ $schedule->topik }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $schedule->tanggal->format('H:i') }}</p>
                </div>
                @if($schedule->is_active)
                <a href="{{ route('mahasiswa.absensi.scan', $schedule->barcode_token) }}" 
                   class="px-3 py-1 bg-blue-100 text-blue-600 text-sm rounded-md">
                    Absen Sekarang
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-500 text-center py-4">Tidak ada jadwal hari ini</p>
    @endif
</div>
@endsection