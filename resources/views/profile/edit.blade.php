<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Kiri: Profile Card -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                        <!-- Profile Image -->
                        <div class="mb-6">
                            <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 overflow-hidden">
                                <img src="https://via.placeholder.com/96x96/000000/FFFFFF?text=VM" 
                                     alt={{ auth()->user()->name }}
                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="text-xl font-bold text-gray-900 mb-5">{{ auth()->user()->name }}</div>

                        <!-- Job Title -->
                        <div class="text-gray-600 text-sm mb-6">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if(auth()->user()->role === 'admin') bg-red-100 text-red-800
                                @elseif(auth()->user()->role === 'dosen') bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>

                        <!-- Social Media Icons -->
                        <div class="flex justify-center space-x-4">
                          
                        </div>
                    </div>
                </div>

                <!-- Kanan: Setting Forms -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
