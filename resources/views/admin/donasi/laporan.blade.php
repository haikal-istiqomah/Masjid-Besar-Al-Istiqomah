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
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @php
                                            $pt = $donasi->payment_type;
                                            $label = match($pt) {
                                              'echannel'     => 'Mandiri Bill',
                                              'bank_transfer'=> 'Transfer Bank',
                                              'credit_card'  => 'Kartu Kredit',
                                              'qris'         => 'QRIS',
                                              'gopay'        => 'GoPay',
                                              'shopeepay'    => 'ShopeePay',
                                              default        => ($pt ? ucwords(str_replace('_',' ',$pt)) : '-'),
                                            };
                                          @endphp
                                          {{ $label }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">{{ $donasi->created_at->format('d M Y, H:i') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">{{ $donasi->nama_donatur }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @php
                                            $status = strtolower($donasi->status ?? '');
                                            $cls = [
                                                'pending'  => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                'success'  => 'bg-green-100 text-green-800 border border-green-200',
                                                'failed'   => 'bg-red-100 text-red-800 border border-red-200',
                                                'expired'  => 'bg-gray-200 text-gray-800 border border-gray-300',
                                                'refunded' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                              ][$status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                          @endphp

                                            <span class="inline-flex items-center justify-center rounded-full px-2 py-0.5 text-xs font-semibold {{ $cls }}">
                                              {{ ucfirst($status ?: '-') }}
                                            </span>
                                        
                                            {{-- Aksi ubah status (inline) --}}
                                            <form action="{{ route('admin.donasi.set-status', $donasi) }}" method="POST" class="inline-flex items-center gap-1 ml-2">
                                                @csrf @method('PATCH')
                                                <select name="status" class="border rounded text-xs px-1 py-0.5">
                                                @foreach (['pending','success','failed','expired','refunded'] as $opt)
                                                    <option value="{{ $opt }}" @selected($donasi->status === $opt)>{{ ucfirst($opt) }}</option>
                                                @endforeach
                                                </select>
                                                <button class="text-xs bg-slate-700 text-white px-2 py-0.5 rounded">Ubah</button>
                                            </form>
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