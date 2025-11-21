<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Besar Al-Istiqomah</title>
    <link rel="icon" href="{{ asset('images/logo-masjid.jpg') }}">
    
    {{-- Load Tailwind & JS App --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js (Wajib untuk Navbar Mobile) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('layouts.public-navigation')

    {{-- Konten Utama --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
                <div>
                    <h4 class="font-bold text-lg text-green-700 mb-4 flex items-center gap-2">
                        <img src="{{ asset('images/logo-masjid.jpg') }}" class="h-6 w-auto" alt="Logo">
                        Al-Istiqomah
                    </h4>
                    <p class="text-gray-600 mb-2">Jl. Gerbang Dayaku RT.06, Desa Loa Duri Ilir, Kec. Loa Janan, Kutai Kartanegara.</p>
                    <p class="text-gray-600">Email: alistiqomah14@gmail.com</p>
                    <p class="text-gray-600">WA: 0822 54589345</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Akses Cepat</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ route('zakat.index') }}" class="hover:text-green-600 transition">Hitung Zakat</a></li>
                        <li><a href="{{ route('donasi.create') }}" class="hover:text-green-600 transition">Donasi Infaq</a></li>
                        <li><a href="{{ route('front.laporan.index') }}" class="hover:text-green-600 transition">Transparansi Keuangan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Media Sosial</h4>
                    <div class="flex gap-3">
                        <a href="https://instagram.com" target="_blank" class="bg-gray-100 p-2 rounded hover:bg-green-100 transition text-gray-600 hover:text-green-700">Instagram</a>
                        <a href="https://facebook.com" target="_blank" class="bg-gray-100 p-2 rounded hover:bg-blue-100 transition text-gray-600 hover:text-blue-700">Facebook</a>
                        <a href="https://youtube.com" target="_blank" class="bg-gray-100 p-2 rounded hover:bg-red-100 transition text-gray-600 hover:text-red-700">YouTube</a>
                    </div>
                </div>
            </div>
            <div class="border-t mt-8 pt-6 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Masjid Besar Al-Istiqomah. All rights reserved.
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>