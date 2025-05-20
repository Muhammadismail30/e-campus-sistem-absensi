@props(['matkul'])

<div class="bg-white rounded-lg shadow-md p-6 mb-4 relative" x-data="{ showEdit: false, showDelete: false }">
    <!-- Mode Tampilan -->
    <div x-show="!showEdit">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold text-lg">{{ $matkul->nama }}</h3>
                <p class="text-gray-600 text-sm mt-1">Kode: {{ $matkul->kode }}</p>
                <p class="text-gray-600 text-sm">SKS: {{ $matkul->sks }}</p>
            </div>
            {{-- <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                {{ $matkul->kelas->count() }} Kelas
            </span> --}}
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 flex flex-wrap gap-2">
            <button @click="showEdit = true" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600">
                ✏️ Edit
            </button>
            <button @click="showDelete = true" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                🗑️ Hapus
            </button>
            {{-- <a href="{{ route('kelas.create', ['matkul_id' => $matkul->id]) }}" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">
                ➕ Buat Kelas
            </a>
            <a href="{{ route('absensi.index', $matkul->id) }}" class="px-3 py-1 bg-purple-500 text-white rounded text-sm hover:bg-purple-600">
                📝 Absensi
            </a> --}}
        </div>
    </div>

    <!-- Mode Edit -->
    <div x-show="showEdit" x-cloak class="bg-gray-50 p-4 rounded-lg">
        <form method="POST" action="{{ route('matakuliah.update', $matkul->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                    Nama Matkul
                </label>
                <input name="nama" value="{{ $matkul->nama }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="kode">
                    Kode Matkul
                </label>
                <input name="kode" value="{{ $matkul->kode }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sks">
                    SKS Matkul
                </label>
                <input name="sks" value="{{ $matkul->sks }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="showEdit = false" class="px-3 py-1 bg-gray-500 text-white rounded text-sm">
                    Batal
                </button>
                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Hapus -->
    <div x-show="showDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="my-4">Yakin ingin menghapus mata kuliah {{ $matkul->nama }}?</p>
            <div class="flex justify-end space-x-2">
                <button @click="showDelete = false" class="px-3 py-1 bg-gray-500 text-white rounded text-sm">
                    Batal
                </button>
                <form method="POST" action="{{ route('matakuliah.destroy', $matkul->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>