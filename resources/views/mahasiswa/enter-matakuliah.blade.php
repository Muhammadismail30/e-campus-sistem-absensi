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

    {{-- Grid untuk Konten Utama: Materi, Tugas, Absensi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-8">

        {{-- Kolom Materi --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 border-b-2 border-sky-500 pb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m0 0A7.5 7.5 0 0019.5 12H4.5a7.5 7.5 0 007.5 5.747z"></path></svg>
                Materi Perkuliahan
            </h2>
            <div class="space-y-4 text-gray-700">
                <p class="italic">Informasi dan daftar materi perkuliahan akan ditampilkan di bagian ini.</p>
                
                {{-- Contoh Tampilan Statis Materi (Placeholder) --}}
                <div class="p-4 bg-sky-50 rounded-lg border border-sky-200 hover:border-sky-400 transition-colors">
                    <h3 class="font-medium text-sky-700">Modul 1: Pengenalan Dasar</h3>
                    <p class="text-sm text-gray-600 mt-1">File: <span class="font-mono">Pengantar_Dasar.pdf</span> (Tidak dapat diunduh)</p>
                </div>
                <div class="p-4 bg-sky-50 rounded-lg border border-sky-200 hover:border-sky-400 transition-colors">
                    <h3 class="font-medium text-sky-700">Modul 2: Konsep Lanjutan</h3>
                    <p class="text-sm text-gray-600 mt-1">File: <span class="font-mono">Konsep_Lanjutan.pptx</span> (Tidak dapat diunduh)</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg border border-gray-300 text-center mt-4">
                    <p class="text-sm text-gray-500">Fungsionalitas penuh untuk materi belum tersedia.</p>
                </div>
            </div>
        </div>

        {{-- Kolom Tugas --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 border-b-2 border-amber-500 pb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Tugas
            </h2>
            <div class="space-y-4 text-gray-700">
                <p class="italic">Daftar tugas dan informasi terkait akan ditampilkan di bagian ini.</p>
                
                {{-- Contoh Tampilan Statis Tugas (Placeholder) --}}
                <div class="p-4 bg-amber-50 rounded-lg border border-amber-200 hover:border-amber-400 transition-colors">
                    <h3 class="font-medium text-amber-700">Tugas 1: Analisis Kasus</h3>
                    <p class="text-sm text-gray-600 mt-1">Deadline: <span class="font-semibold">Segera Diumumkan</span></p>
                </div>
                 <div class="p-4 bg-gray-100 rounded-lg border border-gray-300 text-center mt-4">
                    <p class="text-sm text-gray-500">Fungsionalitas penuh untuk tugas belum tersedia.</p>
                </div>
            </div>
        </div>

        {{-- Kolom Absensi --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h2 class="text-2xl font-semibold mb-5 text-gray-800 border-b-2 border-emerald-500 pb-3 flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Absensi & Kehadiran
            </h2>
            <div class="space-y-3 text-gray-700">
                <p class="italic">Status absensi dan rekapitulasi kehadiran Anda akan ditampilkan di sini.</p>
                
                {{-- Contoh Tampilan Statis Absensi (Placeholder) --}}
                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                    <p class="text-sm font-medium text-emerald-700">Sesi Absensi Saat Ini:</p>
                    <p class="text-base font-semibold text-emerald-800">Belum ada sesi yang aktif.</p>
                </div>
                <div class="p-4 bg-gray-100 rounded-lg border border-gray-200">
                    <p class="text-sm">Kehadiran Anda: <span class="font-bold">N/A</span></p>
                    <p class="text-sm">Total Sesi: <span class="font-bold">N/A</span></p>
                </div>
                <button type="button" class="mt-4 w-full px-4 py-2.5 bg-sky-500 text-white font-medium rounded-lg hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-opacity-75 disabled:opacity-60 disabled:cursor-not-allowed" disabled>
                    Isi Absensi (Nonaktif)
                </button>
            </div>
        </div>

    </div>

</div>
@endsection

@push('styles')
{{-- Jika Anda menggunakan Font Awesome atau ikon lain via CDN dan belum di-load di layout utama --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
{{-- Saya menggunakan ikon SVG Heroicons dan custom SVG, jadi tidak perlu Font Awesome untuk contoh ini --}}
<style>
    /* Tambahan style kustom jika diperlukan */
    .font-mono {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
@endpush