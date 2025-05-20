@props(['matkul'])

<div class="bg-[#DFF5FF] rounded-lg shadow-md border border-black p-4 relative" x-data="{ showEdit: false, showDelete: false }">
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

        <div class="flex justify-end mt-4 gap-2">
            <button @click="showEdit = true" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-1 px-3 rounded">
                ✏️ Edit
            </button>
            <button @click="showDelete = true" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-1 px-3 rounded">
                🗑️ Hapus
            </button>
        </div>
    </div>

    <!-- Mode Edit -->
    <div x-show="showEdit" x-cloak class="bg-gray-100 p-4 rounded-lg mt-4 border border-black">
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

            <div class="flex justify-end space-x-2">
                <button type="button" @click="showEdit = false" class="bg-gray-500 text-white text-sm px-3 py-1 rounded">Batal</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Modal Hapus -->
    <div x-show="showDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full border border-black">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="my-4">Yakin ingin menghapus mata kuliah <strong>{{ $matkul->nama }}</strong>?</p>
            <div class="flex justify-end space-x-2">
                <button @click="showDelete = false" class="bg-gray-500 text-white text-sm px-3 py-1 rounded">Batal</button>
                <form method="POST" action="{{ route('matakuliah.destroy', $matkul->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
