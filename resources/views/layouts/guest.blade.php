<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Masjid Besar Al-Istiqomah' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (NAV untuk publik) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-gray-100">

    {{-- ========== NAV PUBLIK ========== --}}
    @include('layouts.public-navigation')

    {{-- ========== MAIN CONTENT ========== --}}
    <main class="mt-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

</body>
</html>
