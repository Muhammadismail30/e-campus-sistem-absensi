<div x-data="{ isOpen: false }" class="flex h-screen bg-gray-100">

   
    <aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white flex-shrink-0 flex flex-col">
       
        <div class="flex items-center gap-2 h-16 px-4 bg-white text-black shadow">
            <img class="h-10" src="./resources/img/ith.png" alt="Logo">
            <span class="font-bold text-xl">E-CAMPUS</span>
        </div>

        
        <nav class="mt-4 space-y-1 px-4">
            <a href="/home" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->is('home') ? 'bg-cyan-500' : 'hover:bg-cyan-600' }}">
                <i class="fas fa-th-large w-5"></i> Dashboard
            </a>
            <a href="/matakuliah" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->is('matakuliah') ? 'bg-cyan-500' : 'hover:bg-cyan-600' }}">
                <i class="fas fa-book w-5"></i> Mata Kuliah
            </a>
            <a href="/jadwal" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->is('jadwal') ? 'bg-cyan-500' : 'hover:bg-cyan-600' }}">
                <i class="fas fa-calendar-alt w-5"></i> Jadwal
            </a>
            <a href="/presensi" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium {{ request()->is('presensi') ? 'bg-cyan-500' : 'hover:bg-cyan-600' }}">
                <i class="fas fa-check-square w-5"></i> Presensi
            </a>
        </nav>
    </aside>

    
    <div class="flex flex-col flex-1 overflow-hidden">
        
        
        <header class="h-16 bg-white shadow flex items-center justify-end px-6">
            <div class="relative" @click.away="isOpen = false">
                <button @click="isOpen = !isOpen" class="flex items-center gap-2 focus:outline-none">
                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <span class="text-sm font-medium text-gray-700">toril palopo</span>
                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.25 7.75L10 12.5l4.75-4.75" />
                    </svg>
                </button>

                
                <div x-show="isOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                </div>
            </div>
        </header>

        
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>
