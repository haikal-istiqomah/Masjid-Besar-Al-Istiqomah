<nav class="w-full bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        {{-- Logo & Nama Masjid --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
            <span class="font-bold text-lg">Masjid Besar Al-Istiqomah</span>
        </a>

        {{-- Menu --}}
        <div class="flex items-center gap-6">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="{{ route('berita.publik.index') }}" class="nav-link">Berita</a>
            <a href="{{ route('laporan.index') }}" class="nav-link">Laporan Keuangan</a>
            <a href="#footer" class="nav-link">Kontak</a>
        </div>
    </div>
</nav>

<style>
.nav-link {
    color: #333;
    font-weight: 500;
    padding: 6px 8px;
}
.nav-link:hover {
    color: #0ea5e9;
}
</style>
