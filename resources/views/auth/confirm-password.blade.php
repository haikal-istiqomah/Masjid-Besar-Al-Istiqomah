<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
            Area Aman
        </h2>

        <div class="mb-6 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Ini adalah area aman aplikasi. Mohon konfirmasi password Anda sebelum melanjutkan.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="mb-2 text-sm font-medium" />
                <x-text-input id="password" 
                              class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                              type="password"
                              name="password"
                              required 
                              autocomplete="current-password"
                              placeholder="Masukkan password Anda" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Tombol Konfirmasi -->
            <div class="flex justify-end mt-4 pt-4">
                <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                    {{ __('Konfirmasi') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>