<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Masjid Besar Al-Istiqomah</title>
    <link rel="icon" href="{{ asset('images/logo-masjid.jpg') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center relative">

    {{-- BACKGROUND IMAGE (Opsional: Mengambil dari slide landing page agar senada) --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/landing/slide1.jpg') }}" alt="Background Masjid" class="w-full h-full object-cover opacity-20 blur-sm">
        <div class="absolute inset-0 bg-gradient-to-t from-green-900/50 to-transparent"></div>
    </div>

    {{-- CARD LOGIN --}}
    <div class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl overflow-hidden border border-white/50">
        
        {{-- Header Card --}}
        <div class="bg-green-700 p-6 text-center">
            <a href="{{ url('/') }}" class="inline-block transition transform hover:scale-105">
                {{-- Pastikan logo ada, jika tidak tampilkan placeholder teks --}}
                <img src="{{ asset('images/logo-masjid.jpg') }}" alt="Logo" class="h-20 w-auto mx-auto bg-white rounded-full p-1 shadow-md">
            </a>
            <h2 class="mt-4 text-2xl font-bold text-white">Admin Panel</h2>
            <p class="text-green-100 text-sm">Masjid Besar Al-Istiqomah</p>
        </div>

        <div class="p-8 pt-6">
            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="mb-5 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded shadow-sm flex items-start">
                    <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email DKM</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" required 
                            class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required 
                            class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-600 cursor-pointer hover:text-gray-800">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                        <span class="ml-2">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform hover:-translate-y-0.5">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-center">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-green-700 font-medium flex items-center transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Website Utama
            </a>
        </div>
    </div>

    <div class="absolute bottom-4 text-center text-gray-500 text-xs z-10">
        &copy; {{ date('Y') }} Sistem Informasi Masjid Besar Al-Istiqomah.
    </div>

</body>
</html>