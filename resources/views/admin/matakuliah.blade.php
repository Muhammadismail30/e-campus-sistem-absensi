@extends("components.layout",["title" => "Mata Kuliah"])
@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header dan Tombol Tambah -->
    <div class="flex justify-between items-center mb-6">
        <a href="#" onclick="document.getElementById('tambahMatkulModal').showModal()" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Matkul
        </a>
    </div>  

    <!-- Daftar Matkul -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($matkuls as $matkul)
            <x-matakuliah-card 
                :matkul="$matkul"
                :dosens="$dosens" 
            />
        @endforeach
    </div>

<!-- Modal Tambah -->
    <dialog id="tambahMatkulModal" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <form method="POST" action="{{ route('matakuliah.store') }}" class="space-y-4">
            @csrf
            <h3 class="font-bold text-lg">Tambah Mata Kuliah</h3>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode</label>
                <input type="text" name="kode" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">SKS</label>
                <input 
                    type="number" 
                    name="sks" 
                    required 
                    min="2" 
                    max="6" 
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                    oninput="validateSKS(this)"
                >
            </div>
            
            <!-- Tambahkan dropdown dosen -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Pengampu</label>
                <select name="dosen_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->user->name }} ({{ $dosen->nidn }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('tambahMatkulModal').close()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </dialog>
</div>
@endsection