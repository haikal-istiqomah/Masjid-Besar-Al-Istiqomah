<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Zakat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        {{-- Filter --}}
                        <form method="GET" class="mb-6 flex gap-4">
                            <select name="jenis" class="border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="">Semua Jenis</option>
                                <option value="profesi" {{ request('jenis') == 'profesi' ? 'selected' : '' }}>Profesi</option>
                                <option value="maal" {{ request('jenis') == 'maal' ? 'selected' : '' }}>Maal</option>
                                <option value="perniagaan" {{ request('jenis') == 'perniagaan' ? 'selected' : '' }}>Perniagaan</option>
                            </select>
                            
                            <select name="status" class="border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Berhasil (Paid)</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </form>
                    
                    {{-- Tombol Export --}}
                    <a href="{{ route('admin.zakat.export', request()->query()) }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none transition ease-in-out duration-150">
                        📥 Export Excel
                    </a>
                </div>
                
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Muzakki (Nama)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($zakats as $z)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $z->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $z->nama ?? 'Hamba Allah' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($z->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">
                                        Rp {{ number_format($z->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($z->status == 'paid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                        @elseif($z->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($z->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm flex justify-center gap-2">
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="{{ route('admin.zakat.show', $z) }}" class="text-gray-600 hover:text-blue-600" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        {{-- Tombol Set Lunas (Hanya jika pending) --}}
                                        @if($z->status == 'pending')
                                        <form action="{{ route('admin.zakat.update-status', $z) }}" method="POST" onsubmit="return confirm('Ubah status ke Paid manual?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="paid">
                                            <button class="text-green-600 hover:text-green-900" title="Set Lunas">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-gray-500">Belum ada data zakat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $zakats->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>