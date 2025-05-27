@props([
    'matkul',
    'dosens' => null,
    'role' => auth()->user()->role ?? 'guest'
])

{{-- Pastikan $matkul, $dosens sudah didefinisikan di controller --}}
{{-- Contoh penggunaan: <x-matakuliah-card :matkul="$matkul" :dosens="$dosens" /> --}}

{{-- Card untuk menampilkan detail mata kuliah --}}
{{-- Menggunakan Alpine.js untuk interaksi --}}

<div class="bg-[#DFF5FF] rounded-lg shadow-md border border-black p-4 relative" x-data="{ 
    showEdit: false, 
    showDelete: false,
    showDetail: false,
    showMasukModal: false,
    kodeMatkul: ''
}">
    <!-- Mode Tampilan -->
    <div x-show="!showEdit && !showDetail">
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

        <!-- Buttons berdasarkan role -->
        <div class="flex justify-end mt-4 gap-2">
            @if($role === 'admin')
                <!-- Tombol untuk Admin -->
                <button @click="showEdit = true" class="bg-blue-500 hover:bg-[#00B1CB] text-white text-sm font-semibold py-1 px-3 rounded">
                    ✏️ Edit
                </button>
                <button @click="showDelete = true" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-1 px-3 rounded">
                    🗑️ Hapus
                </button>
                <a href="{{ route('admin.matakuliah.detail', $matkul->id) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded">
                    🔍 Detail
                </a>
            @elseif($role === 'dosen')
                <!-- Tombol untuk Dosen -->

                <button @click="showMasukModal = true" 
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-1 px-3 rounded">
                    🚪 Masuk
                </button>
            @elseif($role === 'mahasiswa')
                <!-- Tombol untuk Mahasiswa -->
                <button @click="showDetail = true" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-1 px-3 rounded">
                    📚 Lihat
                </button>
                <button @click="showMasukModal = true" 
                        class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded">
                    🚪 Masuk
                </button>
            @endif
        </div>
    </div>

    <!-- Mode Edit (Hanya untuk Admin) -->
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
                @if($dosens)
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1" for="dosen_id">Dosen Pengampu</label>
                        <select name="dosen_id" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ $matkul->dosen_id == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="showEdit = false" class="bg-gray-500 text-white text-sm px-3 py-1 rounded">Batal</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Mode Hapus (Hanya untuk Admin) -->
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

    <!-- Modal Masuk untuk Dosen/Mahasiswa -->
    @if($role === 'dosen' || $role === 'mahasiswa')
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
                    <input x-model="kodeMatkul" type="text" class="w-full border rounded px-3 py-2 text-sm" placeholder="Masukkan kode mata kuliah">
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
    @endif

    <!-- Mode Detail (Untuk Dosen dan Mahasiswa) -->
    @if($role === 'dosen' || $role === 'mahasiswa')
        <div x-show="showDetail" x-cloak class="bg-white p-6 rounded-lg border border-black">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Detail Mata Kuliah</h3>
                <button @click="showDetail = false" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm text-gray-500">Nama Mata Kuliah</div>
                        <div class="font-semibold">{{ $matkul->nama }}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm text-gray-500">Kode Mata Kuliah</div>
                        <div class="font-semibold">{{ $matkul->kode }}</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm text-gray-500">SKS</div>
                        <div class="font-semibold">{{ $matkul->sks }} SKS</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm text-gray-500">Dosen Pengampu</div>
                        <div class="font-semibold">
                            @if($matkul->dosen && $matkul->dosen->user)
                                {{ $matkul->dosen->user->name }}
                            @else
                                <span class="text-gray-400">Belum ada dosen</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($role === 'mahasiswa')
                    <!-- Konten tambahan untuk mahasiswa -->
                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-semibold mb-3">Informasi Pembelajaran</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Status Enrollment:</span>
                                <span class="text-green-600 font-medium">Terdaftar</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jadwal:</span>
                                <span>Senin, 08:00 - 10:30</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ruangan:</span>
                                <span>R.101</span>
                            </div>
                        </div>
                        
                        <!-- Tombol aksi untuk mahasiswa -->
                        <div class="mt-4 flex gap-2">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded">
                                📖 Lihat Materi
                            </button>
                            <button class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded">
                                📝 Tugas
                            </button>
                        </div>
                    </div>
                @elseif($role === 'dosen')
                    <!-- Konten tambahan untuk dosen -->
                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-semibold mb-3">Informasi Pengajaran</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Jumlah Mahasiswa:</span>
                                <span class="font-medium">32 mahasiswa</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jadwal:</span>
                                <span>Senin, 08:00 - 10:30</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ruangan:</span>
                                <span>R.101</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end mt-6">
                <button @click="showDetail = false" class="bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>
    @endif
</div>