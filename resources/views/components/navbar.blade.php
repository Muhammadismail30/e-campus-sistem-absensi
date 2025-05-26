<div class="flex min-h-screen" x-data="{ isOpen: false }">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-[#387ADF] to-[#1E4279] text-white p-4 hidden md:block">
        <div class="flex items-center space-x-2 mb-6">
            <img src="{{ Vite::asset('resources/img/ith.png') }}" alt="Logo" class="w-10 h-10" />
            <h1 class="text-xl font-bold"><span class="text-red-600">E</span>-CAMPUS</h1>
        </div>
        <nav class="space-y-3">
            @auth
                <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Dashboard</a>
                <a href="{{ route(auth()->user()->role . '.matakuliah') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.matakuliah') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Mata Kuliah</a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.datapengguna') }}"
                        class="block px-4 py-2 rounded {{ request()->routeIs('admin.datapengguna') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Data Pengguna</a>
                @endif
                <a href="{{ route(auth()->user()->role . '.presensi') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.presensi') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Presensi</a>
            @endauth
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
            </div>

            <!-- Profile dropdown -->
            <div class="relative ml-auto" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                        alt="Profile" />
                    <svg x-show="!dropdownOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="dropdownOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1 ring-1 ring-black ring-opacity-5">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Mobile Sidebar -->
        <div x-show="isOpen" class="bg-gradient-to-b from-blue-700 to-blue-500 text-white p-4 md:hidden">
            <nav class="space-y-2">
                @auth
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                        class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Dashboard</a>
                    <a href="{{ route(auth()->user()->role . '.matakuliah') }}"
                        class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.matakuliah') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Mata Kuliah</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.datapengguna') }}"
                            class="block px-4 py-2 rounded {{ request()->routeIs('admin.datapengguna') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Data Pengguna</a>
                    @endif
                    <a href="{{ route(auth()->user()->role . '.presensi') }}"
                        class="block px-4 py-2 rounded {{ request()->routeIs(auth()->user()->role . '.presensi') ? 'bg-white text-blue-700 font-semibold' : 'hover:bg-blue-600' }}">Presensi</a>
                @endauth
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