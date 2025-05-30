@extends("components.layout", ["title" => $title ?? "Data Pengguna"])

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Tombol Tambah Data -->
    <div class="flex justify-end mb-4">
        <button id="addDosenBtn" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg mr-2">
            Tambah Dosen
        </button>
        <button id="addMahasiswaBtn" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
            Tambah Mahasiswa
        </button>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-2 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px" id="userTabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" 
                        id="dosen-tab" 
                        data-tabs-target="#dosen" 
                        type="button" 
                        role="tab" 
                        aria-controls="dosen" 
                        aria-selected="true">Dosen</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                        id="mahasiswa-tab"
                        data-tabs-target="#mahasiswa"
                        type="button"
                        role="tab"
                        aria-controls="mahasiswa"
                        aria-selected="false">Mahasiswa</button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Dosen Tab -->
        <div class="hidden p-4" id="dosen" role="tabpanel" aria-labelledby="dosen-tab">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIDN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dosens as $index => $dosen)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->dosen->nidn ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.datapengguna.delete', $dosen->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mahasiswa Tab -->
        <div class="hidden p-4" id="mahasiswa" role="tabpanel" aria-labelledby="mahasiswa-tab">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($mahasiswas as $index => $mahasiswa)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->mahasiswa->nim ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.datapengguna.delete', $mahasiswa->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 id="modalTitle" class="text-lg leading-6 font-medium text-gray-900">Tambah Pengguna</h3>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" id="userId" name="id">
                <input type="hidden" id="userType" name="type">
                <div class="mt-2 px-7 py-3">
                    <input type="text" id="name" name="name" required
                           placeholder="Nama"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <input type="email" id="email" name="email" required
                           placeholder="Email"
                           class="mt-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <input type="password" id="password" name="password"
                           placeholder="Password"
                           class="mt-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div class="items-center px-4 py-3">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()" class="ml-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-tabs-target]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.tabsTarget);
                document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                    panel.classList.add('hidden');
                });
                target.classList.remove('hidden');
                tabs.forEach(t => {
                    t.classList.remove('border-blue-500', 'text-blue-600');
                    t.classList.add('border-transparent');
                });
                this.classList.add('border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent');
            });
        });
        
        // Activate first tab by default
        document.getElementById('dosen-tab').click();

        // Tombol Tambah Dosen
        document.getElementById('addDosenBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Dosen';
            document.getElementById('userForm').action = '{{ route("admin.datapengguna.store") }}';
            document.getElementById('userType').value = 'dosen';
            document.getElementById('userId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = true;
            document.getElementById('userModal').classList.remove('hidden');
        });

        // Tombol Tambah Mahasiswa
        document.getElementById('addMahasiswaBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Mahasiswa';
            document.getElementById('userForm').action = '{{ route("admin.datapengguna.store") }}';
            document.getElementById('userType').value = 'mahasiswa';
            document.getElementById('userId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = true;
            document.getElementById('userModal').classList.remove('hidden');
        });
    });

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }
</script>
@endpush
@endsection