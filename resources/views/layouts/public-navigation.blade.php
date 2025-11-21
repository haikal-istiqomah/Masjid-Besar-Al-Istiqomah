<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('front.landing') }}" class="flex items-center gap-2">
                        {{-- Pastikan file logo ada di public/images --}}
                        <img src="{{ asset('images/logo-masjid.jpg') }}" class="block h-10 w-auto rounded-full shadow-sm" alt="Logo">
                        <span class="font-bold text-lg text-gray-800 hidden sm:block">Al-Istiqomah</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('front.landing')" :active="request()->routeIs('front.landing')">
                        Beranda
                    </x-nav-link>
                    
                    <x-nav-link :href="route('front.berita.index')" :active="request()->routeIs('front.berita.*')">
                        Berita
                    </x-nav-link>

                    <x-nav-link :href="route('front.laporan.index')" :active="request()->routeIs('front.laporan.*')">
                        Laporan Keuangan
                    </x-nav-link>

                    <x-nav-link :href="route('zakat.index')" :active="request()->routeIs('zakat.*')">
                        Zakat
                    </x-nav-link>

                    {{-- Tombol Donasi Menonjol --}}
                    <div class="flex items-center">
                        <a href="{{ route('donasi.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-full transition shadow-md">
                            Donasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('front.landing')" :active="request()->routeIs('front.landing')">
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('front.berita.index')" :active="request()->routeIs('front.berita.*')">
                Berita
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('front.laporan.index')" :active="request()->routeIs('front.laporan.*')">
                Laporan Keuangan
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('zakat.index')" :active="request()->routeIs('zakat.*')">
                Hitung Zakat
            </x-responsive-nav-link>
            <div class="px-4 pt-2">
                <a href="{{ route('donasi.create') }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white font-bold rounded-lg">
                    Donasi Sekarang
                </a>
            </div>
        </div>
    </div>
</nav>