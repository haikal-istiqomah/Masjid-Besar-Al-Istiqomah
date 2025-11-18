<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }
        $sort = $request->input('sort', 'terbaru');
        $query->orderBy('tanggal', $sort == 'terlama' ? 'asc' : 'desc');
        $transaksis = $query->get();
        return view('admin.laporan.index', compact('transaksis'));
    }

    public function create()
    {
        return view('admin.laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'sumber' => 'required|string',
        ]);
        Transaksi::create($validated);
        return redirect()->route('admin.laporan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // PERBAIKAN: Menambahkan fungsi show() yang hilang
    public function show(Transaksi $transaksi)
    {
        return view('admin.laporan.edit', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        return view('admin.laporan.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'sumber' => 'required|string',
        ]);
        $transaksi->update($validated);
        return redirect()->route('admin.laporan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('admin.laporan.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}