<x-guest-layout>

    <!-- Bungkus Form dalam Card yang Rapi -->
    <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
            Verifikasi Email Anda
        </h2>

        <div class="mb-6 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengeklik link yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.') }}
        </div>

        <!-- Status saat link baru saja dikirim -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-medium text-sm text-center text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 rounded-lg p-4">
                {{ __('Link verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
            </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="mt-6 space-y-4">
            <!-- Tombol Kirim Ulang -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <x-primary-button class="w-full justify-center py-3.5 text-base font-semibold">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Tombol Logout -->
            <div class="text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Keluar (Log Out)') }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>