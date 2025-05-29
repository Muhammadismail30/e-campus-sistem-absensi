{{-- resources/views/components/profile-modal.blade.php --}}
<div x-show="showProfile" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 border border-gray-200 shadow-xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Profil Pengguna</h3>
            <button @click="showProfile = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Pesan Success/Error -->
        @if(session('status') === 'profile-updated')
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('message', 'Profil berhasil diperbarui!') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="text-sm font-medium mb-2">Terjadi kesalahan:</div>
                <ul class="text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div x-show="!editMode">
            <!-- Mode Tampilan -->
            <div class="space-y-4">
                <!-- Foto Profil -->
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-100" 
                             src="{{ auth()->user()->avatar ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e' }}" 
                             alt="Profile" />
                        <div class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Informasi Profil -->
                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Nama Lengkap</div>
                        <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="font-semibold text-gray-800">{{ auth()->user()->email }}</div>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Role</div>
                        <div class="font-semibold text-gray-800">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if(auth()->user()->role === 'admin') bg-red-100 text-red-800
                                @elseif(auth()->user()->role === 'dosen') bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'dosen' && auth()->user()->dosen)
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">NIP</div>
                            <div class="font-semibold text-gray-800">{{ auth()->user()->dosen->nip ?? '-' }}</div>
                        </div>
                        
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">Fakultas</div>
                            <div class="font-semibold text-gray-800">{{ auth()->user()->dosen->fakultas ?? '-' }}</div>
                        </div>
                    @endif

                    @if(auth()->user()->role === 'mahasiswa' && auth()->user()->mahasiswa)
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">NIM</div>
                            <div class="font-semibold text-gray-800">{{ auth()->user()->mahasiswa->nim ?? '-' }}</div>
                        </div>
                        
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">Prodi</div>
                            <div class="font-semibold text-gray-800">{{ auth()->user()->mahasiswa->prodi ?? '-' }}</div>
                        </div>

                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">Semester</div>
                            <div class="font-semibold text-gray-800">{{ auth()->user()->mahasiswa->semester ?? '-' }}</div>
                        </div>
                    @endif

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Bergabung Sejak</div>
                        <div class="font-semibold text-gray-800">{{ auth()->user()->created_at->format('d F Y') }}</div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between pt-4 border-t">
                    <button @click="editMode = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        ✏️ Edit Profil
                    </button>
                    <button @click="showProfile = false" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <div x-show="editMode" x-cloak>
            <!-- Mode Edit -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Upload Foto -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-100" 
                                 src="{{ auth()->user()->avatar ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e' }}" 
                                 alt="Profile" id="preview-avatar" />
                            <label for="avatar" class="absolute bottom-0 right-0 bg-blue-500 hover:bg-blue-600 rounded-full p-2 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="border-t pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Ubah Password (Opsional)</h4>
                        
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                                   placeholder="Masukkan password saat ini jika ingin mengubah password">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between pt-4 border-t mt-6">
                    <button type="button" @click="editMode = false" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-avatar').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Reset form saat modal ditutup
document.addEventListener('alpine:init', () => {
    Alpine.data('profileModal', () => ({
        showProfile: false,
        editMode: false,
        init() {
            this.$watch('showProfile', (value) => {
                if (!value) {
                    this.editMode = false;
                    // Reset form errors ketika modal ditutup
                    setTimeout(() => {
                        const form = this.$el.querySelector('form');
                        if (form) form.reset();
                    }, 300);
                }
            });
        }
    }));
});
</script>