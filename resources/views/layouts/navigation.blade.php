<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="/images/logo-masjid.png" class="h-8 w-auto mr-2">
                    <span class="font-bold text-gray-800">Admin Panel</span>
                </a>
            </div>

            <!-- Menu -->
            <div class="flex space-x-8 items-center">

                <a href="{{ route('admin.dashboard') }}"
                   class="text-gray-700 hover:text-black {{ request()->routeIs('admin.dashboard') ? 'font-bold' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.berita.index') }}"
                   class="text-gray-700 hover:text-black {{ request()->routeIs('admin.berita.*') ? 'font-bold' : '' }}">
                    Berita
                </a>

                <a href="{{ route('admin.transaksi.index') }}"
                   class="text-gray-700 hover:text-black {{ request()->routeIs('admin.transaksi.*') ? 'font-bold' : '' }}">
                    Keuangan
                </a>

                <a href="{{ route('admin.donasi.laporan') }}"
                   class="text-gray-700 hover:text-black {{ request()->routeIs('admin.donasi.*') ? 'font-bold' : '' }}">
                    Donasi
                </a>

                <a href="{{ route('admin.harga-emas.index') }}"
                   class="text-gray-700 hover:text-black {{ request()->routeIs('admin.harga-emas.*') ? 'font-bold' : '' }}">
                    Harga Emas
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-red-600 font-semibold">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
