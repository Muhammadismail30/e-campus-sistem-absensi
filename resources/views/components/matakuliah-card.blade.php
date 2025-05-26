@props([
    'matkul',
    'dosens' => null,
    'role' => auth()->user()->role ?? 'guest'
])

{{-- Pastikan $matkul, $dosens, dan $mahasiswas sudah didefinisikan di controller --}}
{{-- Contoh penggunaan: <x-matakuliah-card :matkul="$matkul" :dosens="$dosens" /> --}}

{{-- Card untuk menampilkan detail mata kuliah --}}
{{-- Menggunakan Alpine.js untuk interaksi --}}

<div class="bg-[#DFF5FF] rounded-lg shadow-md border border-black p-4 relative" x-data="{ 
    showEdit: false, 
    showDelete: false,
    showMasukModal: false,
    kodeMatkul: ''
}">
    <!-- Mode Tampilan -->
    <div x-show="!showEdit">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h2 class="text-md font-semibold">{{ $matkul->nama }}</h2>
                <p class="text-sm text-gray-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 2a1 1 0 00-1 1v1H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2h-.002V3a1 1 0 00-1-1H6z"/>
                    </svg>
                    Kode: {{ $matkul->kode }}
                </p>
            </div>
            <div class="text-sm text-gray-600 absolute top-2 right-4">{{ $matkul->sks }} SKS</div>
        </div>

        <div class="grid grid-cols-3 gap-4 text-sm mt-4 border-t pt-4 border-black">
            <div>
                <div class="text-gray-500">Nama</div>
                <div class="text-base font-bold">{{ $matkul->nama }}</div>
            </div>
            <div>
                <div class="text-gray-500">Kode</div>
                <div class="text-base font-bold">{{ $matkul->kode }}</div>
            </div>
            <div>
                <div class="text-gray-500">SKS</div>
                <div class="text-base font-bold">{{ $matkul->sks }}</div>
            </div>
        </div>

        <!-- Tambahan: Informasi Dosen Pengampu -->
        <div class="mt-4 border-t pt-4 border-black">
            <div class="text-gray-500">Dosen Pengampu</div>
            <div class="text-base font-bold flex items-center gap-2">
                @if($matkul->dosen && $matkul->dosen->user)
                    {{ $matkul->dosen->user->name }}
                @else
                    <span class="text-gray-400">Belum ada dosen</span>
                @endif
            </div>
        </div>

         <!-- Tombol Aksi Berdasarkan Role -->
        <div class="flex justify-end mt-4 gap-2">
        @if($role === 'admin')
            <!-- Admin - Detail -->
            <a href="{{ route('admin.matakuliah.detail', $matkul->id) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-1 px-3 rounded">
                🔍 Detail
            </a>
        @elseif($role === 'dosen')
            <!-- Dosen - Masuk -->
            <button @click="showMasukModal = true" 
                    class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded">
                🚪 Masuk
            </button>
        @elseif($role === 'mahasiswa')
            <!-- Mahasiswa - Masuk dengan Kode -->
            <button @click="showMasukModal = true" 
                    class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded">
                🚪 Masuk (Kode)
            </button>
        @endif
    </div>

    <!-- Modal Masuk untuk Dosen/Mahasiswa -->
    <div x-show="showMasukModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="font-bold text-lg mb-4">
                @if($role === 'dosen')
                    Manajemen Kelas {{ $matkul->nama }}
                @else
                    Masuk Kelas {{ $matkul->nama }}
                @endif
            </h3>
            
            @if($role === 'mahasiswa')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Masukkan Kode Matkul</label>
                <input x-model="kodeMatkul" type="text" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            @endif

            <div class="flex justify-between items-center">
                <button @click="showMasukModal = false" 
                        class="bg-gray-500 text-white text-sm px-3 py-1 rounded">
                    Batal
                </button>
                
                @if($role === 'dosen')
                    <a href="{{ route('dosen.matakuliah.manage', $matkul->id) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">
                        Masuk Kelas
                    </a>
                @else
                    <button @click="if(kodeMatkul === '{{ $matkul->kode }}') { window.location.href = '{{ route('mahasiswa.matakuliah.enter', $matkul->id) }}' } else { alert('Kode matkul salah!') }" 
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">
                        Konfirmasi
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Mode Edit -->
    @if($role === 'admin')
    <div x-show="showEdit" x-cloak class="bg-[#DFF5FF] p-4 rounded-lg mt-4 border border-black">
        <form method="POST" action="{{ route('matakuliah.update', $matkul->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="nama">Nama Matkul</label>
                <input name="nama" value="{{ $matkul->nama }}" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="kode">Kode Matkul</label>
                <input name="kode" value="{{ $matkul->kode }}" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="sks">SKS</label>
                <input name="sks" value="{{ $matkul->sks }}" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
            </div>
            
            <!-- Tambahan: Dropdown Dosen Pengampu di Form Edit -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="dosen_id">Dosen Pengampu</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ $matkul->dosen_id == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->user->name }} <!-- Hanya tampilkan nama -->
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="showEdit = false" class="bg-gray-500 text-white text-sm px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Simpan</button>
            </div>
        </form>
    </div>
    @endif

    <!-- Mode Hapus -->
    @if($role === 'admin')
    <div x-show="showDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full border border-black">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="my-4">Yakin ingin menghapus mata kuliah <strong>{{ $matkul->nama }}</strong>?</p>
            <div class="flex justify-end space-x-2">
                <button @click="showDelete = false" class="bg-gray-500 text-white text-sm px-3 py-1 rounded-lg">Batal</button>
                <form method="POST" action="{{ route('matakuliah.destroy', $matkul->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded-lg">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>