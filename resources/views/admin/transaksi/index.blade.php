<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Transaksi') }}
            </h2>
            <a href="{{ route('admin.transaksi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- FORM FILTER DAN SORTING -->
                    <form action="{{ route('admin.transaksi.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <div>
                                <label for="tanggal_akhir" class="block text-sm font-medium">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <div>
                                <label for="sort" class="block text-sm font-medium">Urutkan</label>
                                <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                </select>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Filter
                                </button>
                                <a href="{{ route('admin.transaksi.index') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 text-center">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- TABEL DATA -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Tanggal</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Keterangan</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Sumber</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Jenis</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-right">Jumlah</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($transaksis ?? [] as $transaksi)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $transaksi->keterangan }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ ucwords(str_replace('_', ' ', $transaksi->sumber)) }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">{{ $transaksi->jenis }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <a href="{{ route('admin.transaksi.edit', $transaksi) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.transaksi.destroy', $transaksi) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

