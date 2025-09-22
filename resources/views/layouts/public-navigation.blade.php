<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    {{-- Link ke Halaman Utama --}}
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')">
                        {{ __('Laporan Keuangan') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('berita.publik.index')" :active="request()->routeIs('berita.publik.index')">
                        {{ __('Berita') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                {{-- TOMBOL BARU DITAMBAHKAN DI SINI --}}
                <a href="{{ route('donasi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-4">
                    Donasi Sekarang
                </a>

                @auth
                    {{-- Jika pengguna sudah login, tampilkan link ke Dashboard --}}
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    {{-- Jika tidak ada yang login, tampilkan link ke halaman Login --}}
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
