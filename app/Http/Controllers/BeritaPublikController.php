<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaPublikController extends Controller
{
    /**
     * Menampilkan halaman utama yang berisi semua berita.
     */
    public function index()
    {
        // Ambil semua berita, urutkan dari yang paling baru, dan gunakan paginasi
        $beritas = Berita::latest()->paginate(9);

        // Ambil semua kategori yang unik untuk ditampilkan sebagai filter
        $kategoris = Berita::select('kategori')->distinct()->pluck('kategori');

        return view('publik.berita.index', compact('beritas', 'kategoris'));
    }

    /**
     * Menampilkan berita berdasarkan kategori yang dipilih.
     */
    public function showByKategori($kategori)
    {
        // Ambil berita berdasarkan kategori, urutkan, dan paginasi
        $beritas = Berita::where('kategori', $kategori)->latest()->paginate(9);

        // Ambil semua kategori yang unik
        $kategoris = Berita::select('kategori')->distinct()->pluck('kategori');

        return view('publik.berita.index', compact('beritas', 'kategoris'));
    }
}