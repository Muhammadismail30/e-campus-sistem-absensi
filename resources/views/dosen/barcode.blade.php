@extends("components.layout",  ["title" => "Barcode Kelas"])

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Barcode Absensi</h2>
        <p class="mb-2">Mata Kuliah: {{ $absensi->matkul->nama }}</p>
        <p class="mb-2">Pertemuan: {{ $absensi->pertemuan_ke }}</p>
        <p class="mb-4">Tanggal: {{ $absensi->tanggal->format('d M Y') }}</p>
        
        <div class="flex justify-center mb-6">
            {!! DNS2D::getBarcodeHTML(route('mahasiswa.scan.absensi', $absensi->barcode_token), 'QRCODE', 10, 10) !!}
        </div>
        
        <p class="text-sm text-gray-600 text-center">Scan barcode ini menggunakan aplikasi E-Campus mahasiswa</p>
    </div>
</div>
@endsection