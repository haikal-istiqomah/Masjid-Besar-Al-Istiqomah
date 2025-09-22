<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua berita di panel admin.
     */
    public function index()
    {
        // Mengambil semua berita dan mengurutkannya berdasarkan tanggal publikasi terbaru
        $beritas = Berita::latest('tanggal_publikasi')->get();
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan data dari form tambah berita baru ke database.
     */
    public function store(Request $request)
    {
        // Memvalidasi semua input dari form
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi' => 'required|string', // Memastikan 'isi' diterima
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_publikasi' => 'required|date', // Memastikan 'tanggal_publikasi' diterima
        ]);

        // Menangani upload file gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validated['gambar'] = $path;
        }

        // Membuat slug unik berdasarkan judul
        $validated['slug'] = Str::slug($request->judul);
        
        // Menyimpan data yang sudah divalidasi ke database
        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu berita (diarahkan ke halaman edit).
     */
    public function show(Berita $berita)
    {
        return redirect()->route('admin.berita.edit', $berita);
    }

    /**
     * Menampilkan form untuk mengedit berita yang sudah ada.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Memperbarui data berita yang sudah diedit di database.
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'sometimes|image|max:2048', // 'sometimes' berarti tidak wajib diisi saat update
            'tanggal_publikasi' => 'required|date',
        ]);

        $validated['slug'] = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validated['gambar'] = $path;
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus data berita dari database dan file gambarnya dari storage.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
