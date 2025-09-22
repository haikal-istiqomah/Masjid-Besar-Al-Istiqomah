<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- =============================================== --}}
    {{-- == TAMBAHKAN BLOK KODE INI UNTUK X-CLOAK == --}}
    {{-- =============================================== --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    
    <header class="bg-white dark:bg-gray-800 shadow">
        @include('layouts.public-navigation')
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} Masjid Al-Istiqomah. All Rights Reserved.
    </footer>

</body>
</html>