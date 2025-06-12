@extends('components.layout', ['title' => $matkul->nama])

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('info') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

                <div class="flex items-center mb-4">
                <a href="{{ route('mahasiswa.matakuliah',) }}"
                    class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                    Kembali ke Manajemen Kelas
                </a>
            </div>

    <!-- Header Mata Kuliah -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold">{{ $matkul->nama }}</h1>
            <div class="mt-2 flex flex-col sm:flex-row sm:gap-6">
                <div>
                    <span class="text-sm opacity-80">Dosen Pengampu:</span>
                    <span class="font-semibold ml-1">
                        @if($matkul->dosen && $matkul->dosen->user)
                            {{ $matkul->dosen->user->name }}
                        @else
                            <span class="text-gray-200">Belum ada dosen</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-sm opacity-80">SKS:</span>
                    <span class="font-semibold ml-1">{{ $matkul->sks }} SKS</span>
                </div>
            </div>
        </div>
        <span class="bg-teal-100 text-teal-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
            Semester {{ $matkul->semester ?? 'N/A' }} - {{ $matkul->tahun_akademik ?? '2024/2025' }}
        </span>
    </div>

    <!-- Panel Sesi Perkuliahan dan Absensi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Sesi Perkuliahan -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
            <div class="px-6 py-5 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-indigo-700">Sesi Perkuliahan</h3>
            </div>
            <div class="border-t border-gray-200">
                @if($activeAbsensi)
                <div class="px-6 py-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                        <p class="text-sm font-medium text-gray-700">Pertemuan ke: {{ $activeAbsensi->pertemuan_ke }}</p>
                        <p class="text-sm text-gray-600 mt-1">Topik: {{ $activeAbsensi->topik }}</p>
                        <p class="text-sm text-gray-600 mt-1">Tanggal: {{ $activeAbsensi->tanggal->format('Y-m-d') }}</p>
                    </div>
                </div>
                @else
                <div class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm font-medium">Belum ada sesi perkuliahan</p>
                    <p class="text-xs mt-1">Dosen belum membuat sesi untuk mata kuliah ini</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Absensi & Kehadiran -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
            <div class="px-6 py-5 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-indigo-700">Absensi & Kehadiran</h3>
                <span class="text-green-500 text-xl font-medium">✓</span>
            </div>
            <div class="border-t border-gray-200">
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-600">Sesi Absensi terakhir:</p>
                    @if($activeAbsensi)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4 mt-2">
                        <p class="text-sm font-medium text-gray-700">Pertemuan ke: {{ $activeAbsensi->pertemuan_ke }}</p>
                        <p class="text-sm text-gray-600 mt-1">Topik: {{ $activeAbsensi->topik }}</p>
                        <p class="text-sm text-gray-600 mt-1">Tanggal: {{ $activeAbsensi->tanggal->format('Y-m-d') }}</p>
                    </div>
                    <button id="scanButton" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded-lg w-full transition-colors">
                        Absen / Scan Absen
                    </button>
                    <div id="scannerContainer" class="hidden mt-4">
                        <div class="relative" style="width: 100%; max-width: 400px; margin: 0 auto;">
                            <div id="preview" style="width: 100%; min-height: 300px; border-radius: 8px; background: #f0f0f0;"></div>
                            <div class="scanner-overlay"></div>
                            <div class="scanner-guide"></div>
                        </div>
                        <p id="scanResult" class="text-sm text-gray-600 mt-2 text-center"></p>
                        <button id="closeScanner" class="mt-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg w-full transition-colors">
                            Tutup Scanner
                        </button>
                    </div>

                    <style>
                        .scanner-overlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0,0,0,0.3);
                            z-index: 1;
                        }
                        
                        .scanner-guide {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            width: 70%;
                            height: 70%;
                            border: 3px solid #3b82f6;
                            border-radius: 8px;
                            z-index: 2;
                            box-shadow: 0 0 0 100vmax rgba(0,0,0,0.5);
                        }
                    </style>
                    @else
                    <p class="text-sm text-gray-600 font-medium mt-1">Belum ada sesi yang aktif</p>
                    <div class="mt-4 bg-orange-100 text-orange-800 text-sm py-2 px-3 rounded flex justify-between items-center shadow-sm">
                        <span>Tidak Ada Sesi Aktif</span>
                        <span class="text-orange-600 text-lg">⚠</span>
                    </div>
                    @endif
                    <div class="mt-4 text-sm text-gray-600">
                        <span class="font-medium">Statistik Kehadiran Anda:</span>
                        <div class="flex justify-between mt-2">
                            <span>Hadir</span>
                            <span class="font-medium text-indigo-600">{{ $hadir }}</span>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span>Total Sesi</span>
                            <span class="font-medium text-indigo-600">{{ $totalSesi }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            console.error('CSRF token tidak ditemukan');
            return;
        }

        const scanButton = document.getElementById('scanButton');
        const scannerContainer = document.getElementById('scannerContainer');
        const previewElement = document.getElementById('preview');
        const scanResult = document.getElementById('scanResult');
        const closeScanner = document.getElementById('closeScanner');

        let html5QrcodeScanner = null;
        let isScanning = false;

        // Fungsi untuk menampilkan modal/popup
        function showSuccessPopup(data) {
            // Buat elemen popup
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            popup.innerHTML = `
                <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mt-3">Absen Berhasil!</h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Nama: ${data.nama}</p>
                            <p>NIM: ${data.nim}</p>
                            <p>Waktu: ${data.waktu}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="this.parentElement.parentElement.remove()" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(popup);
        }

        scanButton.addEventListener('click', function() {
            if (isScanning) return;
            isScanning = true;
            
            scannerContainer.classList.remove('hidden');
            scanButton.disabled = true;
            scanResult.innerHTML = '<div class="bg-blue-100 p-3 rounded">Menyiapkan scanner...</div>';

            const config = {
                fps: 10,
                qrbox: 250,
                aspectRatio: 1.0,
                disableFlip: false
            };

            html5QrcodeScanner = new Html5Qrcode("preview");
            
            html5QrcodeScanner.start(
                { facingMode: "environment" },
                config,
                async (decodedText) => {
                    try {
                        console.log('QR code terbaca:', decodedText);
                        const token = decodedText.split('/').pop();
                        
                        // Pause scanner dan tampilkan loading
                        await html5QrcodeScanner.pause();
                        scanResult.innerHTML = '<div class="bg-blue-100 p-3 rounded">Memproses absen...</div>';
                        
                        const response = await fetch(`/absensi/scan/${token}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        const data = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(data.error || 'Gagal melakukan absen');
                        }

                        if (data.success) {
                            // Tampilkan popup sukses
                            showSuccessPopup(data.data);
                            
                            // Stop scanner sepenuhnya
                            await html5QrcodeScanner.stop();
                            isScanning = false;
                            scannerContainer.classList.add('hidden');
                            
                            // Refresh halaman setelah 2 detik
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.error || 'Gagal melakukan absen');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        scanResult.innerHTML = `
                            <div class="bg-red-100 p-3 rounded">
                                ${error.message}
                            </div>`;
                        
                        // Resume scanning jika masih aktif
                        if (html5QrcodeScanner && isScanning) {
                            try {
                                await html5QrcodeScanner.resume();
                            } catch (e) {
                                console.error('Gagal melanjutkan scanner:', e);
                            }
                        }
                    }
                },
                (errorMessage) => {
                    if (!errorMessage.includes('NotFoundException')) {
                        console.log('Scan Error:', errorMessage);
                    }
                }
            ).catch(err => {
                console.error('Error starting scanner:', err);
                scanResult.innerHTML = '<div class="bg-red-100 p-3 rounded">Gagal memulai scanner</div>';
                scanButton.disabled = false;
                isScanning = false;
            });
        });

        closeScanner?.addEventListener('click', async function() {
            if (html5QrcodeScanner) {
                try {
                    await html5QrcodeScanner.stop();
                } catch (err) {
                    console.error('Error stopping scanner:', err);
                }
            }
            scannerContainer.classList.add('hidden');
            scanButton.disabled = false;
            isScanning = false;
        });
    });
</script>
@endpush

<style>
    .fixed {
        position: fixed;
    }
    .inset-0 {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    .bg-opacity-50 {
        background-color: rgba(0, 0, 0, 0.5);
    }
    .flex {
        display: flex;
    }
    .items-center {
        align-items: center;
    }
    .justify-center {
        justify-content: center;
    }
    .z-50 {
        z-index: 50;
    }
</style>
@endsection