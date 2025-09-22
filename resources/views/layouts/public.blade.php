<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Masjid Besar Al-Istiqomah </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-bold text-xl text-indigo-600">
                Masjid Besar Al-Istiqomah
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600">Beranda</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Berita</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Laporan Keuangan</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Kontak</a>
            </div>
            </div>
    </nav>

    <main class="container mx-auto p-8">
        @yield('content')
    </main>

    <footer class="bg-white mt-12">
        <div class="container mx-auto p-6 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Sistem Informasi Masjid. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>