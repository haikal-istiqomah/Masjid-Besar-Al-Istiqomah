<x-guest-layout>

{{-- Judul Halaman --}}
<div class="text-center mb-10">
    <h1 class="text-3xl font-bold text-gray-800">Kalkulator Zakat</h1>
    <p class="text-gray-500 mt-2 text-sm">Hitung kewajiban zakat Anda dengan mudah dan akurat.</p>
</div>

{{-- Wrapper Desktop --}}
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

    {{-- =======================
         KOLOM KIRI: FORM INPUT
    ======================== --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        
        {{-- NAVIGASI TAB (Diperbaiki Style-nya) --}}
         <nav class="mb-6 flex flex-wrap gap-2 p-1 bg-gray-50 rounded-lg">
          <button type="button" data-tab="profesi" class="tab-btn flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-gray-200">Profesi</button>
          <button type="button" data-tab="maal" class="tab-btn flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-gray-200">Maal (Harta)</button>
          <button type="button" data-tab="perniagaan" class="tab-btn flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-gray-200">Perniagaan</button>
        </nav>

        {{-- FORM WRAPPER --}}
        
        {{-- TAB 1: ZAKAT PROFESI --}}
        <div id="tab-profesi" class="tab-content">
          <form onsubmit="return false;" class="space-y-5">
            
            {{-- Identitas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Nama Lengkap</label>
                    <input id="nama_profesi" type="text" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Hamba Allah">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Email <span class="text-red-500 text-xs">(Untuk Bukti Bayar)</span></label>
                    <input id="email_profesi" type="email" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="email@contoh.com">
                </div>
            </div>

            <div class="py-2">
                <div class="border-t border-gray-100"></div>
            </div>

            {{-- Checkbox Manual --}}
            <div class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                <input id="chk_manual_profesi" type="checkbox" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                <label for="chk_manual_profesi" class="ml-3 text-sm font-medium text-gray-800 cursor-pointer select-none">
                    Saya sudah punya hitungan zakat sendiri
                </label>
            </div>

            {{-- Area Auto --}}
            <div id="area_auto_profesi" class="space-y-4 transition-all duration-300">
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Penghasilan Bulanan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                        <input id="penghasilan_profesi" type="text" class="pl-10 border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Pendapatan Lainnya (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                        <input id="tambahan_profesi" type="text" class="pl-10 border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Hutang/Cicilan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                        <input id="pengeluaran_profesi" type="text" class="pl-10 border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-600">Jumlah Bulan</label>
                        <input id="bulan_profesi" type="number" min="1" value="1" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-600">Metode Nisab</label>
                        <select id="nisab_profesi" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="emas">Emas (85 gr)</option>
                            <option value="beras">Beras (522 kg)</option>
                        </select>
                    </div>
                </div>
                <div id="wrapper_beras_profesi" class="hidden">
                    <label class="block mb-1 font-medium text-sm text-gray-600">Harga Beras per Kg (Rp)</label>
                    <input id="harga_beras_profesi" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" value="15.000">
                </div>
            </div>

            {{-- Area Manual --}}
            <div id="area_manual_profesi" class="hidden p-5 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block mb-2 font-bold text-emerald-800 text-lg">Masukkan Nominal Zakat</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-lg">Rp</span>
                    <input id="manual_profesi" type="text" class="pl-12 border-emerald-500 border-2 rounded-lg w-full rupiah text-2xl font-bold text-gray-800 py-3 focus:ring-emerald-200" placeholder="0">
                </div>
                <p class="text-xs text-gray-500 mt-2">*Masukkan jumlah zakat final yang ingin Anda bayarkan.</p>
            </div>
          </form>
        </div>

        {{-- TAB 2: ZAKAT MAAL --}}
        <div id="tab-maal" class="tab-content hidden">
          <form onsubmit="return false;" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Nama Lengkap</label>
                    <input id="nama_maal" type="text" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500" placeholder="Hamba Allah">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Email <span class="text-red-500 text-xs">(Untuk Bukti Bayar)</span></label>
                    <input id="email_maal" type="email" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500" placeholder="email@contoh.com">
                </div>
            </div>
            <div class="py-2"><div class="border-t border-gray-100"></div></div>
            <div class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                <input id="chk_manual_maal" type="checkbox" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                <label for="chk_manual_maal" class="ml-3 text-sm font-medium text-gray-800 cursor-pointer select-none">Saya sudah punya hitungan sendiri</label>
            </div>
            <div id="area_auto_maal" class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Uang Tunai/Tabungan (Rp)</label>
                    <input id="uang_maal" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Nilai Emas/Surat Berharga (Rp)</label>
                    <input id="harta_maal" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Aset Properti (Disewakan) (Rp)</label>
                    <input id="lainnya_maal" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Hutang Jatuh Tempo (Rp)</label>
                    <input id="hutang_maal" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
            </div>
            <div id="area_manual_maal" class="hidden p-5 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block mb-2 font-bold text-emerald-800 text-lg">Masukkan Nominal Zakat</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-lg">Rp</span>
                    <input id="manual_maal" type="text" class="pl-12 border-emerald-500 border-2 rounded-lg w-full rupiah text-2xl font-bold text-gray-800 py-3" placeholder="0">
                </div>
            </div>
          </form>
        </div>

        {{-- TAB 3: ZAKAT PERNIAGAAN --}}
        <div id="tab-perniagaan" class="tab-content hidden">
          <form onsubmit="return false;" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Nama Lengkap</label>
                    <input id="nama_perniagaan" type="text" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500" placeholder="Hamba Allah">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-sm text-gray-700">Email <span class="text-red-500 text-xs">(Untuk Bukti Bayar)</span></label>
                    <input id="email_perniagaan" type="email" class="border-gray-300 rounded-lg w-full focus:border-emerald-500 focus:ring-emerald-500" placeholder="email@contoh.com">
                </div>
            </div>
            <div class="py-2"><div class="border-t border-gray-100"></div></div>
            <div class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                <input id="chk_manual_perniagaan" type="checkbox" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                <label for="chk_manual_perniagaan" class="ml-3 text-sm font-medium text-gray-800 cursor-pointer select-none">Saya sudah punya hitungan sendiri</label>
            </div>
            <div id="area_auto_perniagaan" class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Modal Diputar (Rp)</label>
                    <input id="modal_perniagaan" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Keuntungan (Rp)</label>
                    <input id="pendapatan_perniagaan" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Piutang Lancar (Rp)</label>
                    <input id="piutang_perniagaan" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-600">Hutang Jatuh Tempo (Rp)</label>
                    <input id="hutang_perniagaan" type="text" class="border-gray-300 rounded-lg w-full rupiah focus:border-emerald-500 focus:ring-emerald-500" placeholder="0">
                </div>
            </div>
            <div id="area_manual_perniagaan" class="hidden p-5 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block mb-2 font-bold text-emerald-800 text-lg">Masukkan Nominal Zakat</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-lg">Rp</span>
                    <input id="manual_perniagaan" type="text" class="pl-12 border-emerald-500 border-2 rounded-lg w-full rupiah text-2xl font-bold text-gray-800 py-3" placeholder="0">
                </div>
            </div>
          </form>
        </div>

    </div>

    {{-- =======================
         KOLOM KANAN: HASIL
    ======================== --}}
    <div class="relative">
        <div class="sticky top-6">
            {{-- Card Ringkasan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-emerald-500">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ringkasan Zakat
                </h2>

                <div class="space-y-4 text-sm text-gray-700">
                    
                    {{-- PERBAIKAN: Menggunakan gap-2 agar berdekatan --}}
                    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                        <span class="text-gray-500">Jenis Zakat:</span>
                        <span id="out_jenis" class="font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded">Profesi</span>
                    </div>
                    
                    {{-- Panel Otomatis --}}
                    <div id="info_auto_panel" class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Nisab (Batas):</span>
                            <div class="text-right">
                                <span id="out_nisab" class="font-mono font-medium block">Rp 0</span>
                                <span class="text-xs text-gray-400" id="out_dasar">Nisab Emas</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">Harta Wajib:</span>
                            <span id="out_total" class="font-mono font-bold text-gray-800">Rp 0</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status:</span>
                            <span id="out_status" class="font-bold text-gray-400">-</span>
                        </div>
                    </div>

                    {{-- Pesan Manual --}}
                    <div id="info_manual_msg" class="hidden">
                        <div class="bg-yellow-50 text-yellow-700 px-3 py-2 rounded text-center text-xs font-semibold border border-yellow-100">
                            ⚠️ Menggunakan Perhitungan Manual
                        </div>
                    </div>
                </div>

                {{-- Total Bayar --}}
                <div class="mt-8 pt-6 border-t border-dashed border-gray-300 text-center">
                    <p class="text-gray-500 mb-2 text-xs uppercase tracking-wide">Total Zakat yang Harus Dibayar</p>
                    <div id="out_jumlah" class="text-4xl font-extrabold text-emerald-600">Rp 0</div>
                </div>

                {{-- Tombol Bayar (Ganti Warna Kuning) --}}
                <div class="mt-8">
                    <form id="payForm" action="{{ route('zakat.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jenis" id="pay_jenis">
                        <input type="hidden" name="jumlah" id="pay_jumlah">
                        <input type="hidden" name="nama" id="pay_nama">
                        <input type="hidden" name="email" id="pay_email">
                        
                        <button id="btnPay" class="w-full bg-yellow-500 hover:bg-yellow-400 text-green-900 font-extrabold py-4 px-6 rounded-xl shadow-lg transition transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:bg-gray-300 disabled:text-gray-500" disabled>
                            BAYAR ZAKAT SEKARANG &rarr;
                        </button>
                    </form>
                    <div class="flex justify-center mt-4 gap-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="h-4 opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1200px-Bank_Mandiri_logo_2016.svg.png" class="h-4 opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/QRIS_logo.svg/1200px-QRIS_logo.svg.png" class="h-4 opacity-50 grayscale">
                    </div>
                </div>
            </div>

            {{-- Info Harga Emas --}}
            <div class="mt-4 bg-yellow-50 border border-yellow-100 rounded-lg p-3 text-center">
                <p class="text-xs text-yellow-800">
                    <span class="font-bold">ℹ️ Info:</span> Harga Emas Acuan: 
                    <span class="font-mono font-bold">Rp <span id="gold_price_display">{{ number_format($goldPriceInit ?? 0, 0, ',', '.') }}</span></span> / gram
                </p>
            </div>
        </div>
    </div>

</div>

<script>
    const hargaEmas = Number("{{ $goldPriceInit ?? 0 }}") || 0;
    let activeTab = 'profesi';

    const toNumber = v => {
        if (!v) return 0;
        return Number(v.toString().replace(/\./g, '').replace(/,/g, '')) || 0;
    };
    const fmtRupiah = v => new Intl.NumberFormat('id-ID').format(Math.round(v));

    // --- UPDATE LOGIKA TABS (Agar Hover tidak aneh) ---
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    function setActiveTab(tabId) {
        activeTab = tabId;
        // Reset semua tombol ke style inactive
        tabButtons.forEach(btn => {
            if (btn.dataset.tab === tabId) {
                // Style Active
                btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                btn.classList.add('bg-emerald-600', 'text-white', 'shadow-md');
            } else {
                // Style Inactive
                btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                btn.classList.remove('bg-emerald-600', 'text-white', 'shadow-md');
            }
        });

        // Show/Hide Content
        tabContents.forEach(el => {
            if (el.id === 'tab-' + tabId) {
                el.classList.remove('hidden');
                // Animasi Fade In sederhana
                el.style.opacity = 0;
                setTimeout(() => el.style.opacity = 1, 50);
            } else {
                el.classList.add('hidden');
            }
        });
        
        calculateAll();
    }

    // Event Listener Click Tab
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => setActiveTab(btn.dataset.tab));
    });

    // Init default tab
    setActiveTab('profesi');


    // --- INPUT LISTENERS ---
    document.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', calculateAll);
        el.addEventListener('change', calculateAll);
    });

    document.querySelectorAll('.rupiah').forEach(input => {
        input.addEventListener('input', function() {
            const val = this.value.replace(/[^0-9]/g, '');
            this.value = val ? fmtRupiah(val) : '';
        });
    });

    ['profesi', 'maal', 'perniagaan'].forEach(type => {
        const chk = document.getElementById(`chk_manual_${type}`);
        const autoArea = document.getElementById(`area_auto_${type}`);
        const manualArea = document.getElementById(`area_manual_${type}`);

        chk.addEventListener('change', () => {
            if(chk.checked) {
                autoArea.classList.add('hidden');
                manualArea.classList.remove('hidden');
            } else {
                autoArea.classList.remove('hidden');
                manualArea.classList.add('hidden');
            }
            calculateAll();
        });
    });

    const nisabSelect = document.getElementById('nisab_profesi');
    const berasWrapper = document.getElementById('wrapper_beras_profesi');
    nisabSelect.addEventListener('change', () => {
        if(nisabSelect.value === 'beras') {
            berasWrapper.classList.remove('hidden');
        } else {
            berasWrapper.classList.add('hidden');
        }
        calculateAll();
    });

    function calculateAll() {
        let result = 0;
        let totalHarta = 0;
        let nisab = 0;
        let dasarText = '-';
        let isWajib = false;
        let isManual = document.getElementById(`chk_manual_${activeTab}`).checked;

        // Ambil input nama & email setiap kali ada perubahan (untuk validasi)
        let nama = document.getElementById(`nama_${activeTab}`).value;
        let email = document.getElementById(`email_${activeTab}`).value;

        if (isManual) {
            result = toNumber(document.getElementById(`manual_${activeTab}`).value);
            document.getElementById('info_auto_panel').classList.add('hidden');
            document.getElementById('info_manual_msg').classList.remove('hidden');
        } else {
            document.getElementById('info_auto_panel').classList.remove('hidden');
            document.getElementById('info_manual_msg').classList.add('hidden');

            if (activeTab === 'profesi') {
                const g = toNumber(document.getElementById('penghasilan_profesi').value);
                const b = toNumber(document.getElementById('tambahan_profesi').value);
                const p = toNumber(document.getElementById('pengeluaran_profesi').value);
                const bln = Number(document.getElementById('bulan_profesi').value) || 1;
                const metode = document.getElementById('nisab_profesi').value;
                
                totalHarta = (g + b - p) * bln;
                if(totalHarta < 0) totalHarta = 0;

                if (metode === 'beras') {
                    const hrgBeras = toNumber(document.getElementById('harga_beras_profesi').value);
                    nisab = 522 * hrgBeras;
                    dasarText = 'Setara 522 Kg Beras';
                } else {
                    nisab = (85 * hargaEmas) / 12;
                    dasarText = 'Setara 85 gr Emas (Bulanan)';
                }

                if (totalHarta >= nisab) {
                    isWajib = true;
                    result = Math.round(totalHarta * 0.025);
                }

            } else if (activeTab === 'maal') {
                const uang = toNumber(document.getElementById('uang_maal').value);
                const emas = toNumber(document.getElementById('harta_maal').value);
                const properti = toNumber(document.getElementById('lainnya_maal').value);
                const hutang = toNumber(document.getElementById('hutang_maal').value);

                totalHarta = uang + emas + properti - hutang;
                if(totalHarta < 0) totalHarta = 0;

                nisab = 85 * hargaEmas;
                dasarText = 'Setara 85 gr Emas';

                if (totalHarta >= nisab) {
                    isWajib = true;
                    result = Math.round(totalHarta * 0.025);
                }

            } else if (activeTab === 'perniagaan') {
                const modal = toNumber(document.getElementById('modal_perniagaan').value);
                const untung = toNumber(document.getElementById('pendapatan_perniagaan').value);
                const piutang = toNumber(document.getElementById('piutang_perniagaan').value);
                const hutang = toNumber(document.getElementById('hutang_perniagaan').value);

                totalHarta = (modal + untung + piutang) - hutang;
                if(totalHarta < 0) totalHarta = 0;

                nisab = 85 * hargaEmas;
                dasarText = 'Setara 85 gr Emas';

                if (totalHarta >= nisab) {
                    isWajib = true;
                    result = Math.round(totalHarta * 0.025);
                }
            }
        }

        document.getElementById('out_jenis').textContent = activeTab.charAt(0).toUpperCase() + activeTab.slice(1);
        document.getElementById('out_jumlah').textContent = 'Rp ' + fmtRupiah(result);
        
        // LOGIKA TOMBOL BAYAR (Wajib Email)
        const btnPay = document.getElementById('btnPay');
        // Aktif jika: Nominal > 0 DAN Email tidak kosong
        if (result > 0 && email.trim() !== '') {
            btnPay.disabled = false;
            btnPay.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btnPay.disabled = true;
            btnPay.classList.add('opacity-50', 'cursor-not-allowed');
        }

        if (!isManual) {
            document.getElementById('out_total').textContent = 'Rp ' + fmtRupiah(totalHarta);
            document.getElementById('out_nisab').textContent = 'Rp ' + fmtRupiah(nisab);
            document.getElementById('out_dasar').textContent = dasarText;
            
            const statusEl = document.getElementById('out_status');
            if(isWajib) {
                statusEl.textContent = 'WAJIB ZAKAT';
                statusEl.className = 'font-bold text-green-600';
            } else {
                statusEl.textContent = 'BELUM WAJIB';
                statusEl.className = 'font-bold text-gray-400';
            }
        }

        document.getElementById('pay_jenis').value = activeTab;
        document.getElementById('pay_jumlah').value = result;
        document.getElementById('pay_nama').value = nama;
        document.getElementById('pay_email').value = email;
    }
</script>

</x-guest-layout>