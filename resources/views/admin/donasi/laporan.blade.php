<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Donasi Masuk') }}
        </h2>
    </x-slot>

    {{-- Inisialisasi State Alpine.js untuk Modal --}}
    <div class="py-12" x-data="{ 
        showModal: false, 
        editUrl: '', 
        currentStatus: '',
        openEdit(url, status) {
            this.editUrl = url;
            this.currentStatus = status;
            this.showModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Filter & Export --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <form action="{{ route('admin.donasi.laporan') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                            <select name="status" class="border-gray-300 rounded-md text-sm shadow-sm dark:bg-gray-700" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Sukses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            
                            <select name="payment_type" class="border-gray-300 rounded-md text-sm shadow-sm dark:bg-gray-700" onchange="this.form.submit()">
                                <option value="">Semua Metode</option>
                                <option value="bank_transfer" {{ request('payment_type') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="qris" {{ request('payment_type') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                <option value="manual_transfer" {{ request('payment_type') == 'manual_transfer' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </form>

                        <a href="{{ route('admin.donasi.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-green-700 transition">
                            📥 Export Excel
                        </a>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Order ID & Tanggal</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Donatur</th>
                                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Metode</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse ($daftar_donasi as $donasi)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-bold text-gray-900 dark:text-gray-200">{{ $donasi->order_id }}</div>
                                        <div class="text-xs text-gray-500">{{ $donasi->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">{{ $donasi->nama_donatur }}</div>
                                        @if($donasi->email)
                                            <div class="text-xs text-gray-500">{{ $donasi->email }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-700 dark:text-gray-300">
                                        Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $donasi->metode_pembayaran_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $donasi->status_badge_class }}">
                                            {{ ucfirst($donasi->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button 
                                            type="button"
                                            x-on:click="openEdit('{{ route('admin.donasi.set-status', $donasi) }}', '{{ $donasi->status }}')"
                                            class="text-blue-600 hover:text-blue-900 font-medium text-sm flex items-center justify-center gap-1 mx-auto">
                                            ✏️ Edit
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">Belum ada data donasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $daftar_donasi->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT STATUS (Alpine.js) --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" x-transition.scale class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="editUrl" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Update Status Donasi
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Ubah status pembayaran secara manual. <br>
                                    <span class="text-red-500 font-bold">Peringatan:</span> Jangan ubah ke 'Success' jika uang belum masuk!
                                </p>
                                
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Status Baru</label>
                                <select name="status" x-model="currentStatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700">
                                    <option value="pending">Pending (Menunggu)</option>
                                    <option value="success">Success (Lunas)</option>
                                    <option value="failed">Failed (Gagal)</option>
                                    <option value="expired">Expired (Kadaluarsa)</option>
                                    <option value="refunded">Refunded (Dikembalikan)</option>
                                </select>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- END MODAL --}}

    </div>
</x-app-layout>