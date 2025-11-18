<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
            Login
        </h2>

        <!-- Session Status -->
        <!-- Ini sudah ada di kodemu, bagus untuk memberi feedback -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Alamat Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-2 text-sm font-medium" />
                <x-text-input id="email" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              autofocus 
                              autocomplete="username" 
                              placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="mb-2 text-sm font-medium" />
                <x-text-input id="password" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                              type="password"
                              name="password"
                              required 
                              autocomplete="current-password"
                              placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Tombol Login (Dibuat full-width) -->
            <div class="flex items-center justify-end mt-4 pt-4">
                <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <!-- Link ke Register (Opsional, tapi direkomendasikan) -->
            @if (Route::has('register'))
                <p class="text-sm text-center text-gray-600 dark:text-gray-400 pt-4 border-t dark:border-gray-700">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 underline">
                        Daftar di sini
                    </a>
                </p>
            @endif

        </form>
    </div>
</x-guest-layout>