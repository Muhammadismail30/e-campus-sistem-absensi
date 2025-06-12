@extends('components.layout', ['title' => 'Manajemen Kelas'])

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ activeTab: 'absensi' }">
        <!-- Button kembali -->
        <div class="flex items-center mb-4">
            <a href="{{ route('dosen.matakuliah') }}"
                class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                Kembali ke daftar mata kuliah
            </a>
        </div>

        <!-- Header Mata Kuliah -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $matkul->nama }}</h1>
                <p class="mt-1 text-sm text-gray-600">Kode Mata Kuliah: {{ $matkul->kode }}</p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                Semester {{ $matkul->semester ?? 'N/A' }} - {{ $matkul->tahun_akademik ?? '2024/2025' }}
            </span>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li>
                    <button @click="activeTab = 'absensi'"
                        :class="activeTab === 'absensi' ? 'border-blue-600 text-blue-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="inline-block p-4 border-b-2 font-semibold text-sm">
                        Daftar Absensi
                    </button>
                </li>
                <li>
                    <button @click="activeTab = 'mahasiswa'"
                        :class="activeTab === 'mahasiswa' ? 'border-blue-600 text-blue-600' :
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="inline-block p-4 border-b-2 font-semibold text-sm">
                        Daftar Mahasiswa
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content: Daftar Absensi -->
        <div x-show="activeTab === 'absensi'" class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-5 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Sesi Absensi</h3>
                <form action="{{ route('dosen.generate.absensi', $matkul->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Absensi Baru
                    </button>
                </form>
            </div>

            @if ($absensis->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pertemuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Topik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kehadiran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($absensis as $absensi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->pertemuan_ke }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->topik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->tanggal->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $absensi->attendances_count }} / {{ $totalMahasiswa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $absensi->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $absensi->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button
                                            onclick="openEditModal('{{ $absensi->id }}', '{{ $absensi->topik }}', '{{ $absensi->tanggal }}')"
                                            class="text-blue-600 hover:text-blue-900 mr-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="toggleAbsensi({{ $absensi->id }})"
                                            class="text-sm {{ $absensi->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white py-1 px-3 rounded">
                                            {{ $absensi->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                        @if ($absensi->is_active)
                                            <a href="{{ route('dosen.absensi.barcode', $absensi->id) }}"
                                                class="ml-2 text-sm bg-purple-500 hover:bg-purple-600 text-white py-1 px-3 rounded">
                                                Lihat Barcode
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="border-t border-gray-200">
                    <div class="px-6 py-8 text-center text-sm text-gray-500">
                        Belum ada sesi absensi untuk mata kuliah ini.
                    </div>
                </div>
            @endif
        </div>

        <!-- Tab Content: Daftar Mahasiswa -->
        <div x-show="activeTab === 'mahasiswa'" class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-5">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Mahasiswa Terdaftar</h3>
                <!-- Debugging: Tampilkan jumlah mahasiswa -->
                <p class="text-sm text-gray-500">Jumlah mahasiswa:
                    {{ isset($mahasiswas) ? $mahasiswas->count() : 'Tidak terdefinisi' }}</p>
            </div>
            @if (isset($mahasiswas) && $mahasiswas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NIM</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mahasiswas as $index => $mahasiswa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $mahasiswa->user->name ?? 'Nama tidak tersedia' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->nim ?? 'NIM tidak tersedia' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="border-t border-gray-200">
                    <div class="px-6 py-8 text-center text-sm text-gray-500">
                        Belum ada mahasiswa yang terdaftar pada mata kuliah ini.
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal Edit -->
        <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Pertemuan</h3>
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mt-2 px-7 py-3">
                            <input type="text" id="edit_topik" name="topik" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <input type="date" id="edit_tanggal" name="tanggal" required
                                class="mt-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Simpan
                            </button>
                            <button type="button" onclick="closeEditModal()"
                                class="ml-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEditModal(id, topik, tanggal) {
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('edit_topik').value = topik;
                const formattedDate = tanggal.split(' ')[0];
                document.getElementById('edit_tanggal').value = formattedDate;
                document.getElementById('edit_id').value = id;
                document.getElementById('editForm').action = `/dosen/absensi/${id}`;
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            function toggleAbsensi(absensiId) {
                fetch(`/dosen/absensi/${absensiId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status absensi');
                    });
            }
        </script>
    @endpush
@endsection
