<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Zakat') }} #{{ $zakat->order_id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.zakat.index') }}" class="inline-flex items-center mb-4 text-gray-600 hover:text-gray-900 transition">
                &larr; Kembali ke Daftar
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- KOLOM KIRI: Informasi Utama --}}
                <div class="lg:col-span-2 bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Muzakki</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail personal dan jenis zakat.</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                        <dl class="sm:divide-y sm:divide-gray-200">
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $zakat->nama ?? 'Hamba Allah' }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $zakat->email ?? '-' }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $zakat->phone ?? '-' }}</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Jenis Zakat</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 capitalize bg-blue-100 text-blue-800 px-2 py-0.5 rounded inline-block text-xs font-semibold">
                                    {{ $zakat->jenis }}
                                </dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Keterangan Tambahan</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $zakat->keterangan ?? '-' }}</dd>
                            </div>
                            @if($zakat->nominal_perhitungan)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Hasil Kalkulator</dt>
                                <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-2">
                                    Rp {{ number_format($zakat->nominal_perhitungan, 0, ',', '.') }}
                                    <span class="text-xs text-gray-500 block">(Ini adalah angka saran dari kalkulator saat user menghitung)</span>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- KOLOM KANAN: Informasi Pembayaran & Status --}}
                <div class="space-y-6">
                    
                    {{-- Card Status --}}
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Pembayaran</h3>
                        <div class="text-center py-4">
                            <div class="text-3xl font-bold text-gray-900 mb-2">
                                Rp {{ number_format($zakat->jumlah, 0, ',', '.') }}
                            </div>
                            
                            @if($zakat->status == 'paid')
                                <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 font-bold text-sm">LUNAS (PAID)</span>
                            @elseif($zakat->status == 'pending')
                                <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-bold text-sm">PENDING</span>
                            @else
                                <span class="px-4 py-2 rounded-full bg-red-100 text-red-800 font-bold text-sm uppercase">{{ $zakat->status }}</span>
                            @endif

                            <p class="mt-4 text-sm text-gray-500">Tanggal: {{ $zakat->created_at->format('d F Y H:i') }}</p>
                        </div>

                        @if($zakat->status == 'pending')
                        <div class="mt-6 pt-6 border-t">
                            <form action="{{ route('admin.zakat.update-status', $zakat) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="paid">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow" onclick="return confirm('Konfirmasi pembayaran ini secara manual?')">
                                    Verifikasi Manual (Set Lunas)
                                </button>
                                <p class="text-xs text-gray-400 mt-2 text-center">Gunakan tombol ini jika Muzakki membayar tunai atau transfer manual.</p>
                            </form>
                        </div>
                        @endif
                    </div>

                    {{-- Card Data Teknis Midtrans (Untuk Debugging) --}}
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Data Teknis (Midtrans)</h3>
                        <div class="bg-gray-900 rounded p-3 overflow-x-auto">
                            <pre class="text-xs text-green-400 font-mono">{{ json_encode($zakat->midtrans_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>