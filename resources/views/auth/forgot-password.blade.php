<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
            Lupa Password?
        </h2>

        <div class="mb-6 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda.') }}
        </div>

        <!-- Session Status -->
        <!-- Ini akan muncul setelah email terkirim -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Anda')" class="mb-2 text-sm font-medium" />
                <x-text-input id="email" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              autofocus 
                              placeholder="Masukkan email terdaftar Anda" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Tombol Kirim Link -->
            <div class="flex items-center justify-end mt-4 pt-4">
                <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                    {{ __('Kirim Link Reset Password') }}
                </x-primary-button>
            </div>

            <!-- Link kembali ke Login -->
            <div class="text-sm text-center text-gray-600 dark:text-gray-400 pt-4 border-t dark:border-gray-700">
                <a class="underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Kembali ke Login') }}
                </a>
            </div>

        </form>
    </div>
</x-guest-layout>