<x-guest-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <h1 class="text-3xl font-bold mb-2 text-center">Formulir Donasi Masjid</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-8">Setiap donasi Anda sangat berarti untuk kemakmuran masjid.</p>

                    {{-- Menampilkan pesan sukses setelah submit --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('order_id'))
                    <div class="mt-2 text-xs text-gray-500">
                        Kode Donasi: <span class="font-mono">{{ session('order_id') }}</span>
                    </div>
                    @endif

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-700 rounded-lg">
                            <p class="font-bold">Oops! Terjadi kesalahan:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('donasi.store') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Donatur --}}
                        <div class="mb-6">
                            <label for="nama_donatur" class="block mb-2 text-sm font-medium">Nama Donatur</label>
                            <input type="text" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur', 'Hamba Allah') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>

                        {{-- Email Donatur --}}
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium">Email (Opsional)</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="contoh@email.com">
                            <p class="mt-1 text-xs text-gray-500">Digunakan untuk mengirim bukti donasi.</p>
                        </div>

                        {{-- Jumlah Donasi --}}
                        <div class="mb-6">
                            <label for="jumlah_display" class="block mb-2 text-sm font-medium">Jumlah Donasi (minimal Rp 10.000)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="text" id="jumlah_display" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="10.000" required>
                            </div>
                            <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                        </div>

                        {{-- Pesan/Doa --}}
                        <div class="mb-6">
                            <label for="pesan" class="block mb-2 text-sm font-medium">Pesan atau Doa (Opsional)</label>
                            <textarea id="pesan" name="pesan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Semoga menjadi berkah...">{{ old('pesan') }}</textarea>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Lanjutkan Pembayaran
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
                let formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);
                e.target.value = formattedValue;
            } else {
                e.target.value = '';
            }
        });

        if(jumlahHidden.value) {
            jumlahDisplay.value = new Intl.NumberFormat('id-ID').format(jumlahHidden.value);
        }
    </script>
            
             @if(session('snap_token'))
            <div class="mt-6 flex items-center gap-3">
                <button type="button" id="btn-pay" class="px-4 py-2 rounded bg-blue-600 text-white">
                Bayar sekarang
                </button>

                <a href="{{ route('donasi.create', ['new' => 1]) }}"
                class="px-4 py-2 rounded border border-gray-300 text-gray-700">
                Ubah nominal
                </a>
            </div>

            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
            <script>
                const token = @json(session('snap_token'));

                function toQuery(obj){
                const p = new URLSearchParams();
                Object.keys(obj||{}).forEach(k => { if(obj[k] !== undefined) p.append(k, obj[k]); });
                return p.toString();
                }

                function goFinish(result){
                // kirim semua field penting ke /midtrans/finish
                const qs = toQuery(result || {});
                window.location.href = "{{ route('midtrans.finish') }}" + (qs ? ("?"+qs) : "");
                }

                function openSnap(){
                window.snap.pay(token, {
                    onSuccess:  function(result){ goFinish(result); },
                    onPending:  function(result){ goFinish(result); },
                    onError:    function(result){ goFinish(result); },
                    onClose:    function(){ /* dibiarkan, user bisa klik tombol "Bayar sekarang" */ }
                });
                }

                // Auto-open sekali saja per order_id (biar kalau user close, tetap bisa klik tombol)
                @if(session('order_id'))
                const onceKey = 'snap-opened-{{ session('order_id') }}';
                if(!sessionStorage.getItem(onceKey)){
                    openSnap();
                    sessionStorage.setItem(onceKey, '1');
                }
                @else
                // fallback
                openSnap();
                @endif

                document.getElementById('btn-pay').addEventListener('click', openSnap);
            </script>
            @endif
</x-guest-layout>

