<x-guest-layout>
    <div class="flex h-screen w-screen overflow-hidden">
        <!-- Gambar -->
        <div class="w-1/2 hidden md:block">
            <img
                src="{{ Vite::asset('resources/img/bg-login1.png') }}"
                alt="Monumen"
                class="w-full h-full object-cover"
            />
        </div>

        <!-- Form Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-6 h-full overflow-hidden">
            <div class="w-full max-w-md">
                <!-- Logo ITEHA -->
                <div class="text-center mb-8">
                    <img src="{{ Vite::asset('resources/img/ith.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                    <h1 class="text-4xl font-extrabold"><span class="text-red-600">E</span>-CAMPUS</h1>
                    <p class="text-sm text-gray-600 mt-2">Silahkan Log In Terlebih Dahulu</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="('Email')" />
                        <x-text-input
                            id="email"
                            class="block w-full mt-1 px-4 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan NIM/NIDN Anda"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="('Password')" />
                        <x-text-input
                            id="password"
                            class="block w-full mt-1 px-4 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan Password Anda"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mb-4">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
                    </div>

                    <!-- Aksi -->
                    <div class="flex items-center justify-between">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ml-3 bg-blue-500 hover:bg-blue-600">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>