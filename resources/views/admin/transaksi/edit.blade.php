<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.transaksi.update', $transaksi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="jenis" class="block text-sm font-medium">Jenis Transaksi</label>
                                <select name="jenis" id="jenis" class="mt-1 block w-full rounded-md" required>
                                    <option value="Pemasukan" {{ old('jenis', $transaksi->jenis) == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="Pengeluaran" {{ old('jenis', $transaksi->jenis) == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="sumber" class="block text-sm font-medium">Sumber Dana</label>
                                <select name="sumber" id="sumber" class="mt-1 block w-full rounded-md" required>
                                    {{-- PERBAIKAN: value disesuaikan 100% dengan file migrasi --}}
                                    <option value="infaq" {{ old('sumber', $transaksi->sumber) == 'infaq' ? 'selected' : '' }}>Infaq</option>
                                    <option value="zakat maal" {{ old('sumber', $transaksi->sumber) == 'zakat maal' ? 'selected' : '' }}>Zakat Maal</option>
                                    <option value="zakat fitrah" {{ old('sumber', $transaksi->sumber) == 'zakat fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                                    <option value="operasional" {{ old('sumber', $transaksi->sumber) == 'operasional' ? 'selected' : '' }}>Operasional</option>
                                    <option value="lainnya" {{ old('sumber', $transaksi->sumber) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="jumlah_display" class="block text-sm font-medium">Jumlah</label>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">Rp</span>
                                <input type="text" id="jumlah_display" class="pl-8 block w-full rounded-md" required>
                            </div>
                            <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}">
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="4" class="mt-1 block w-full rounded-md" required>{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                             <label for="tanggal" class="block text-sm font-medium">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', optional($transaksi->tanggal)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md" required>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const jumlahDisplay = document.getElementById('jumlah_display');
        const jumlahHidden = document.getElementById('jumlah');
        jumlahDisplay.addEventListener('input', function(e) {
            let rawValue = e.target.value.replace(/[^0-9]/g, '');
            jumlahHidden.value = rawValue;
            if (rawValue) {
                e.target.value = new Intl.NumberFormat('id-ID').format(rawValue);
            } else {
                e.target.value = '';
            }
        });
        if(jumlahHidden.value) {
            jumlahDisplay.value = new Intl.NumberFormat('id-ID').format(jumlahHidden.value);
        }
    </script>
</x-app-layout>
