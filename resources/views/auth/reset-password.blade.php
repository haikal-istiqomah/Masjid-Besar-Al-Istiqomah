<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
            Atur Ulang Password
        </h2>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address (Otomatis terisi) -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-2 text-sm font-medium" />
                <x-text-input id="email" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="email" 
                              name="email" 
                              :value="old('email', $request->email)" 
                              required 
                              autofocus 
                              autocomplete="username" 
                              placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Baru -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password Baru')" class="mb-2 text-sm font-medium" />
                <x-text-input id="password" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                              type="password" 
                              name="password" 
                              required 
                              autocomplete="new-password" 
                              placeholder="Masukkan password baru Anda" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="mb-2 text-sm font-medium" />
                <x-text-input id="password_confirmation" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                              type="password"
                              name="password_confirmation" 
                              required 
                              autocomplete="new-password"
                              placeholder="Ketik ulang password baru Anda" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Tombol Reset -->
            <div class="flex items-center justify-end mt-4 pt-4">
                <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-guest-layout>