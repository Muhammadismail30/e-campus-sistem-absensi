@extends("components.layout",["title" => $title ?? "Data Pengguna"])
@section('content')
<div class="container mx-auto px-4 py-6">
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
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
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
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tab JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-tabs-target]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.tabsTarget);
                
                // Hide all tab contents
                document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Show selected tab content
                target.classList.remove('hidden');
                
                // Update active tab styling
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
    });
</script>
@endsection