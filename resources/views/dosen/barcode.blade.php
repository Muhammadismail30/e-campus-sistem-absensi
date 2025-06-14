@extends('components.layout', ['title' => 'Barcode Kelas'])

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <!-- Button kembali -->
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('dosen.matakuliah.manage', $absensi->mataKuliah->id) }}"
                class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                Kembali ke Manajemen Kelas
            </a>
            
            <form action="{{ route('dosen.absensi.regenerate-token', $absensi->id) }}" method="POST">
                @csrf
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200"
                    onclick="return confirm('Apakah Anda yakin ingin memperbarui token? Token sebelumnya tidak akan bisa digunakan lagi.')">
                    Perbarui Token
                </button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Barcode Absensi</h2>
            <p class="mb-2 font-semibold">Mata Kuliah: <span class="font-normal">{{ $absensi->mataKuliah->nama }}</span></p>
            <p class="mb-2 font-semibold">Pertemuan: <span class="font-normal">{{ $absensi->pertemuan_ke }}</span></p>
            <p class="mb-4 font-semibold">Tanggal: <span class="font-normal">{{ $absensi->tanggal->format('d M Y') }}</span>
            </p>

            <div class="flex flex-col items-center mb-6 bg-white p-4 rounded border border-gray-200">
                <!-- QR code -->
                <div class="p-4 bg-white">
                    {!! DNS2D::getBarcodeHTML(
                        route('mahasiswa.absensi.scan', ['token' => $absensi->barcode_token]),
                        'QRCODE',
                        15,
                        15,
                    ) !!}
                </div>

                <!-- Tambahkan teks token sebagai fallback -->
                <div class="mt-4 p-3 bg-gray-100 rounded text-center">
                    <p class="text-sm font-semibold">Token Absensi:</p>
                    <p class="font-mono text-lg">{{ $absensi->barcode_token }}</p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Scan barcode ini menggunakan aplikasi E-Campus mahasiswa</p>
                <p class="text-xs text-gray-500">Pastikan kamera memiliki fokus yang baik dan pencahayaan cukup</p>
            </div>
        </div>
    </div>

    <style>
        .barcode-container {
            padding: 20px;
            border: 1px solid #e2e8f0;
            background: white;
            margin: 0 auto;
            max-width: 300px;
        }

        svg {
            background-color: white !important;
        }
    </style>
@endsection