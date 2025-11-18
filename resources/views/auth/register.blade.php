<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
            Daftar Akun Baru
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="mb-2 text-sm font-medium" />
                <x-text-input id="name" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="text" 
                              name="name" 
                              :value="old('name')" 
                              required 
                              autofocus 
                              autocomplete="name" 
                              placeholder="Nama Anda" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="mb-2 text-sm font-medium" />
                <x-text-input id="email" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
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
                              autocomplete="new-password"
                              placeholder="Buat password (min. 8 karakter)" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="mb-2 text-sm font-medium" />
                <x-text-input id="password_confirmation" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                              type="password"
                              name="password_confirmation" 
                              required 
                              autocomplete="new-password"
                              placeholder="Ketik ulang password Anda" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Tombol Register (Full-width) -->
            <div class="flex items-center justify-end mt-4 pt-4">
                <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <!-- Link ke Login -->
            <div class="text-sm text-center text-gray-600 dark:text-gray-400 pt-4 border-t dark:border-gray-700">
                <a class="underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Sudah terdaftar? Login di sini') }}
                </a>
            </div>

        </form>
    </div>
</x-guest-layout>