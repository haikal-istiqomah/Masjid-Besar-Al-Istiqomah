<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Donasi Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Form Filter & Ekspor --}}
                    <form action="{{ route('admin.donasi.laporan') }}" method="GET" class="mb-6">
                        {{-- ... (kode filter tidak berubah) ... --}}
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <thead class="ltr:text-left rtl:text-right">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Order ID</th>
                                    {{-- KOLOM BARU --}}
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Metode Pembayaran</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Tanggal</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Nama Donatur</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-right">Jumlah</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium">Status</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($daftar_donasi as $donasi)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium">{{ $donasi->order_id }}</td>
                                        {{-- DATA BARU --}}
                                        <td class="whitespace-nowrap px-4 py-2">{{ $donasi->metode_pembayaran ? ucwords(str_replace('_', ' ', $donasi->metode_pembayaran)) : '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">{{ $donasi->created_at->format('d M Y, H:i') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">{{ $donasi->nama_donatur }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @if($donasi->status == 'Success')
                                                <span class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2-5 py-0.5 text-emerald-700">
                                            @elseif($donasi->status == 'Pending')
                                                <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2-5 py-0.5 text-amber-700">
                                            @else
                                                <span class="inline-flex items-center justify-center rounded-full bg-red-100 px-2-5 py-0.5 text-red-700">
                                            @endif
                                                {{ ucfirst($donasi->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- colspan diubah menjadi 6 --}}
                                        <td colspan="6" class="text-center py-4">Belum ada data donasi.</td>
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