<div class="flex min-h-screen" x-data="{ isOpen: false }">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-[#387ADF] to-[#1E4279] text-white p-4 hidden md:block">
        <div class="flex items-center space-x-2 mb-6">
            <img src="{{ Vite::asset('resources/img/ith.png') }}" alt="Logo" class="w-10 h-10" />
            <h1 class="text-xl font-bold"><span class="text-red-600">E</span>-CAMPUS</h1>
        </div>
        <nav class="space-y-3">
            <a href="{{('dashboard') }}" class="block px-4 py-2 rounded {{ request()->is('dashboard') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Dashboard</a>
            <a href="{{('matakuliah') }}" class="block px-4 py-2 rounded {{ request()->is('matakuliah') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Mata Kuliah</a>
            <a href="{{('jadwal') }}" class="block px-4 py-2 rounded {{ request()->is('jadwal') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Jadwal</a>
            <a href="{{('presensi') }}" class="block px-4 py-2 rounded {{ request()->is('presensi') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Presensi</a>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <nav class="bg-white shadow px-4 h-16 flex items-center justify-between">
            <!-- Sidebar Toggle for Mobile -->
            <div class="flex items-center space-x-2 md:hidden">
                <button @click="isOpen = !isOpen" class="text-gray-600 hover:text-blue-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-xl font-bold">@yield('title', 'Halaman')</h2>
            </div>
            <h2 class="text-xl font-bold hidden md:block">@yield('title', 'Halaman')</h2>

            <!-- Profile dropdown -->
            <div class="relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e" alt="Profile" />
                </button>
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1 ring-1 ring-black ring-opacity-5">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Mobile Sidebar -->
        <div x-show="isOpen" class="bg-gradient-to-b from-blue-700 to-blue-500 text-white p-4 md:hidden">
            <nav class="space-y-2">
                <a href="{{('dashboard') }}" class="block px-4 py-2 rounded {{ request()->is('dashboard') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Dashboard</a>
                <a href="{{('matakuliah') }}" class="block px-4 py-2 rounded {{ request()->is('matakuliah') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Mata Kuliah</a>
                <a href="{{('jadwal') }}" class="block px-4 py-2 rounded {{ request()->is('jadwal') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Jadwal</a>
                <a href="{{('presensi') }}" class="block px-4 py-2 rounded {{ request()->is('presensi') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Presensi</a>
            </nav>
        </div>

        <!-- Main Content Area -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</div>

<!-- Tambahkan Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
