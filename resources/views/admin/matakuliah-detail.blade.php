@extends("components.layout", ["title" => "Detail Mata Kuliah"])

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header Mata Kuliah -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pemrograman Web Lanjut</h1>
            <div class="mt-1 flex flex-wrap items-center gap-4">
                <p class="text-sm text-gray-600">Kode: PW123</p>
                <p class="text-sm text-gray-600">3 SKS</p>
                <p class="text-sm text-gray-600">Dosen: Dr. John Doe</p>
            </div>
        </div>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
            Semester 5 - 2024/2025
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

    <!-- Area Absensi (Contoh dengan Data Dummy) -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Absensi</h3>
        </div>

        <!-- Contoh Tabel dengan Data Dummy -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertemuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Data Dummy 1 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pertemuan 1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Jan 2024 08:00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pengenalan Laravel</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25/30</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                        </td>
                    </tr>
                    <!-- Data Dummy 2 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pertemuan 2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">22 Jan 2024 08:00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">MVC Pattern</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28/30</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                        </td>
                    </tr>
                    <!-- Data Dummy 3 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pertemuan 3</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">29 Jan 2024 08:00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Database Migration</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">27/30</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Jika tidak ada data -->
        <div class="hidden px-6 py-8 text-center text-sm text-gray-500">
            Belum ada riwayat absensi untuk mata kuliah ini.
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Daftar Mata Kuliah
        </a>
    </div>
</div>
@endsection