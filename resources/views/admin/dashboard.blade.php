{{-- <x-layout>
    <x-slot:title>{{$title ?? "Default page"}}</x-slot>

    <div class="mb-4">
        <div class="flex flex-wrap gap-4">
            <!-- Card Mahasiswa -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Mahasiswa Yang Diajar</h2>
                    <ul class="mt-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Kelas IK23-A (48 Mahasiswa)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Kelas IK23-C (52 Mahasiswa)</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>

            <!-- Card Kelas -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Kelas Yang Diajar</h2>
                    <p class="text-sm text-gray-600 mt-1">2 (Kelas)</p>
                    <ul class="mt-1 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>IK23-A</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>IK23-B</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>

            <!-- Card Mata Kuliah -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Mata Kuliah Yang Diajar</h2>
                    <p class="text-sm text-gray-600 mt-1">2 (Mata Kuliah)</p>
                    <ul class="mt-1 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Pemrograman Web</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Rekayasa Perangkat Lunak</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>


</x-layout> --}}

@extends("components.layout",["title" => "Dashboard"])

@section('content')

    <div class="mb-4">
        <div class="flex flex-wrap gap-4">
            <!-- Card Mahasiswa -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Mahasiswa Yang Diajar</h2>
                    <ul class="mt-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Kelas IK23-A (48 Mahasiswa)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Kelas IK23-C (52 Mahasiswa)</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>

            <!-- Card Kelas -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Kelas Yang Diajar</h2>
                    <p class="text-sm text-gray-600 mt-1">2 (Kelas)</p>
                    <ul class="mt-1 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>IK23-A</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>IK23-B</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>

            <!-- Card Mata Kuliah -->
            <div class="bg-sky-50 rounded-lg shadow-sm flex overflow-hidden w-full md:w-[calc(33.33%-1rem)]">
                <div class="p-4 flex items-center justify-center bg-sky-100">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h2 class="font-bold text-gray-800">Mata Kuliah Yang Diajar</h2>
                    <p class="text-sm text-gray-600 mt-1">2 (Mata Kuliah)</p>
                    <ul class="mt-1 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Pemrograman Web</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-1">•</span>
                            <span>Rekayasa Perangkat Lunak</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-3">
                        <a href="#" class="inline-block px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-600 text-xs rounded-md transition">Lainnya</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection