<x-guest-layout>

{{-- Judul Halaman --}}
<h1 class="text-3xl font-semibold text-center text-gray-800 mb-10"> Kalkulator Zakat</h1>

{{-- Wrapper Desktop (Form kiri) --}}
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- =======================
         FORM KALKULATOR
    ======================== --}}
    <div class="bg-white p-6 rounded-lg shadow">
        {{-- NAVIGASI TAB --}}
         <nav class="mb-4 flex gap-3">
          <button type="button" data-tab="profesi" class="tab-btn px-4 py-2 bg-gray-100 rounded">Zakat Profesi</button>
          <button type="button" data-tab="maal" class="tab-btn px-4 py-2 bg-gray-100 rounded">Zakat Maal</button>
          <button type="button" data-tab="perniagaan" class="tab-btn px-4 py-2 bg-gray-100 rounded">Zakat Perniagaan</button>
        </nav>

        {{-- =======================================================
                        TAB: ZAKAT PROFESI
        ======================================================== --}}
        <div id="tab-profesi" class="tab-content">
          <form id="form-profesi" class="space-y-4" onsubmit="return false;">
            @csrf
            <input type="hidden" name="jenis" value="profesi">

            <div>
              <label class="block mb-1 font-medium">Nama (opsional)</label>
              <input id="nama_profesi" name="nama" type="text" class="border rounded p-2 w-full" placeholder="Contoh: Zayad Habihulloh " value="{{ session('zakat_input.nama') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Email (Wajib untuk bukti transaksi)</label>
              <input id="email_profesi" name="email" type="email" class="border rounded p-2 w-full" placeholder="email@contoh.com" value="{{ session('zakat_input.email') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Penghasilan Bulanan (Rp)</label>
              <input id="penghasilan_profesi" name="penghasilan" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" placeholder="Contoh: 5.000.000" value="{{ session('zakat_input.penghasilan') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Penghasilan Tambahan per Bulan (Rp)</label>
              <input id="tambahan_profesi" name="tambahan" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" placeholder="Contoh: 1.000.000" value="{{ session('zakat_input.tambahan') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Pengeluaran Pokok per Bulan (Rp)</label>
              <input id="pengeluaran_profesi" name="pengeluaran" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" placeholder="Contoh: 3.000.000" value="{{ session('zakat_input.pengeluaran') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Jumlah Bulan</label>
              <input id="bulan_profesi" name="bulan" type="number" min="1" class="border rounded p-2 w-full" value="{{ session('zakat_input.bulan') ?? 1 }}">
            </div>

            <div>
              <label class="block mb-1 font-semibold">Dasar Perhitungan Nisab</label>
              <select id="nisab_profesi" name="nisab_metode" class="border rounded p-2 w-full">
                <option value="emas" {{ (session('zakat_input.nisab_metode') ?? 'emas') === 'emas' ? 'selected' : '' }}>Nisab berdasarkan harga emas (85 gr)</option>
                <option value="beras" {{ session('zakat_input.nisab_metode') === 'beras' ? 'selected' : '' }}>Nisab berdasarkan harga beras (522 kg)</option>
              </select>
            </div>

            <div id="beras_profesi_wrapper" class="mt-3 hidden">
              <label class="block mb-1 font-medium">Harga Beras per Kg (Rp)</label>
              <input id="harga_beras_profesi" name="harga_beras" type="text" class="border rounded p-2 w-full rupiah" placeholder="Contoh: 15.000" value="{{ session('zakat_input.harga_beras') ?? '' }}">
              <p class="text-sm text-gray-500 mt-1"><em>Isi sesuai harga beras yang biasa Anda konsumsi.</em></p>
            </div>

            <div class="mt-2">
              <label class="inline-flex items-center">
                <input id="profesi_manual_checkbox" type="checkbox" class="mr-2">
                Saya punya perhitungan sendiri (isi nominal di bawah)
              </label>
            </div>

            <div id="profesi_manual" class="hidden mt-3">
              <label class="block mb-1 font-medium">Nominal Zakat (Rp)</label>
              <input id="manual_jumlah_profesi" name="manual_jumlah_profesi" type="text" class="border rounded p-2 w-full rupiah" placeholder="Rp." value="">
              <div class="mt-2">
                <h2 class="text-xl font-semibold text-emerald-700 mb-3">Untuk Melanjutkan pembayaran,</h2>
                <a class="text-md font-semibold"> Silakan klik tombol 'Bayar Zakat' di panel hasil perhitungan kanan/bawah. </a>
              </div>
            </div>

          </form>
        </div>




        {{-- =======================================================
                        TAB: ZAKAT MAAL
        ======================================================== --}}
        <div id="tab-maal" class="tab-content hidden">
          <form id="form-maal" class="space-y-4" onsubmit="return false;">
            @csrf
            <input type="hidden" name="jenis" value="maal">
          
            <div>
              <label class="block mb-1 font-medium">Nama (opsional)</label>
              <input id="nama_profesi" name="nama" type="text" class="border rounded p-2 w-full" placeholder="Contoh: Zayad Habihulloh " value="{{ session('zakat_input.nama') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Email (Wajib untuk bukti transaksi)</label>
              <input id="email_profesi" name="email" type="email" class="border rounded p-2 w-full" placeholder="email@contoh.com" value="{{ session('zakat_input.email') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Jumlah Harta (Rp)</label>
              <input id="harta_maal" name="harta" type="text" class="border rounded p-2 w-full rupiah" placeholder="Contoh: 100.000.000" inputmode="numeric" value="{{ session('zakat_input.harta') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Uang Tunai / Tabungan (Rp)</label>
              <input id="uang_maal" name="uang" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.uang') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Investasi / Properti / Harta Lainnya (Rp)</label>
              <input id="lainnya_maal" name="lainnya" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.lainnya') ?? '' }}">
            </div>

            <div>
              <label class="block mb-1 font-medium">Hutang Jatuh Tempo (Rp)</label>
              <input id="hutang_maal" name="hutang" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.hutang') ?? '' }}">
            </div>

            <div class="mt-2">
              <label class="inline-flex items-center">
                <input id="maal_manual_checkbox" type="checkbox" class="mr-2">
                Saya punya perhitungan sendiri (isi nominal di bawah)
              </label>
            </div>

            <div id="maal_manual" class="hidden mt-3">
              <label class="block mb-1 font-medium">Nominal Zakat (Rp)</label>
              <input id="manual_jumlah_maal" name="manual_jumlah_maal" type="text" class="border rounded p-2 w-full rupiah" placeholder="Rp." value="">
              <div class="mt-2">
                <h2 class="text-xl font-semibold text-emerald-700 mb-3">Untuk Melanjutkan pembayaran,</h2>
                <a class="text-md font-semibold"> Silakan klik tombol 'Bayar Zakat' di panel hasil perhitungan kanan/bawah. </a>
              </div>
            </div>
          </form>
        </div>



        {{-- =======================================================
                    TAB: ZAKAT PERNIAGAAN
        ======================================================== --}}
        <div id="tab-perniagaan" class="tab-content hidden">
        <form id="form-perniagaan" class="space-y-4" onsubmit="return false;">
          @csrf
          <input type="hidden" name="jenis" value="perniagaan">

          <div>
              <label class="block mb-1 font-medium">Nama (opsional)</label>
              <input id="nama_profesi" name="nama" type="text" class="border rounded p-2 w-full" placeholder="Contoh: Zayad Habihulloh " value="{{ session('zakat_input.nama') ?? '' }}">
            </div>

          <div>
              <label class="block mb-1 font-medium">Email (Wajib untuk bukti transaksi)</label>
              <input id="email_profesi" name="email" type="email" class="border rounded p-2 w-full" placeholder="email@contoh.com" value="{{ session('zakat_input.email') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Modal yang Dijalankan (Rp)</label>
            <input id="modal_perniagaan" name="modal" type="text" class="border rounded p-2 w-full rupiah" placeholder="Contoh:75.000.000" inputmode="numeric" value="{{ session('zakat_input.modal') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Pendapatan Tahunan (Rp)</label>
            <input id="pendapatan_perniagaan" name="pendapatan" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.pendapatan') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Nilai Barang Dagangan (Rp)</label>
            <input id="barang_perniagaan" name="barang" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.barang') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Piutang Lancar (Rp)</label>
            <input id="piutang_perniagaan" name="piutang" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.piutang') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Hutang (Rp)</label>
            <input id="hutang_perniagaan" name="hutang" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.hutang') ?? '' }}">
          </div>

          <div>
            <label class="block mb-1 font-medium">Pengeluaran (Rp)</label>
            <input id="pengeluaran_perniagaan" name="pengeluaran" type="text" class="border rounded p-2 w-full rupiah" inputmode="numeric" value="{{ session('zakat_input.pengeluaran') ?? '' }}">
          </div>

          <div class="mt-2">
            <label class="inline-flex items-center">
              <input id="perniagaan_manual_checkbox" type="checkbox" class="mr-2">
              Saya punya perhitungan sendiri (isi nominal di bawah)
            </label>
          </div>

          <div id="perniagaan_manual" class="hidden mt-3">
            <label class="block mb-1 font-medium">Nominal Zakat (Rp)</label>
            <input id="manual_jumlah_perniagaan" name="manual_jumlah_perniagaan" type="text" class="border rounded p-2 w-full rupiah" placeholder="Rp" value="">
            <div class="mt-2">
              <h2 class="text-xl font-semibold text-emerald-700 mb-3">Untuk Melanjutkan pembayaran,</h2>
              <a class="text-md font-semibold"> Silakan klik tombol 'Bayar Zakat' di panel hasil perhitungan kanan/bawah. </a>
            </div>
          </div>
        </form>
      </div>

    </div>


    {{-- =======================
         Wrapper kanan = PANEL HASIL
    ======================== --}}
    <div id="panel-hasil" class="bg-emerald-50 p-6 rounded-lg shadow">
        <div class="bg-white p-6 rounded">
          <h2 class="text-xl font-semibold text-emerald-700 mb-3">Hasil Perhitungan</h2>

          <div id="hasil-detail" class="text-gray-700 text-md space-y-2">
            <p><strong>Jenis:</strong> <span id="out_jenis">-</span></p>
            <p><strong>Dasar Nisab:</strong> <span id="out_dasar">-</span></p>
            <p><strong>Total Harta:</strong> <span id="out_total">Rp 0</span></p>
            <p><strong>Nisab Saat Ini:</strong> <span id="out_nisab">Rp 0</span></p>
            <p><strong>Status:</strong> <span id="out_status">-</span></p>

            <hr class="my-3">

            <p class="text-gray-600">Jumlah Zakat (2.5% jika wajib):</p>
            <div id="out_jumlah" class="text-3xl font-bold text-emerald-700">Rp 0</div>

            <p class="mt-4 text-center text-gray-600 italic text-sm">
              Bismillah. Saya serahkan zakat saya kepada Yayasan Masjid Al-Istiqomah agar dapat dikelola dengan sebaik-baiknya sesuai dengan ketentuan syariat agama.
            </p>

            <div class="text-center mt-4">
              <form id="payForm" action="{{ route('zakat.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis" id="pay_jenis">
                <input type="hidden" name="jumlah" id="pay_jumlah">
                {{-- TAMBAHAN BARU --}}
                <input type="hidden" name="nama" id="pay_nama">
                <input type="hidden" name="email" id="pay_email">
                
                <button id="btnPay" class="bg-emerald-700 text-white px-6 py-2 rounded">Bayar Zakat</button>
              </form>
            </div>

            <p class="mt-3 text-xs text-gray-500">
              Harga emas saat ini: Rp <span id="out_gold_price">{{ number_format($goldPriceInit ?? session('zakat_harga_emas') ?? 0, 0, ',', '.') }}</span> (dinamis; cache 1 jam)
            </p>
          </div>
        </div>
    </div>
 </div>
 {{-- END GRID WRAPPER HASIL --}}


{{-- ===================================================================
                        SCRIPT LIVE CALC
=================================================================== --}}
<script>
    // helper
    const toNumber = v => {
      if (v === null || v === undefined || v === '') return 0;
      return Number(String(v).replace(/\./g, '').replace(/,/g, '')) || 0;
    };
    const fmtRupiah = v => {
      return new Intl.NumberFormat('id-ID').format(Math.round(v));
    };

    // tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('bg-emerald-100'));
        btn.classList.add('bg-emerald-100');
        const tab = btn.dataset.tab;
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById('tab-' + tab).classList.remove('hidden');
        calculateAll();
      });
    });
    // open default tab
    (function(){
      const last = localStorage.getItem('lastTab') || 'profesi';
      document.querySelector(`[data-tab="${last}"]`)?.click();
    })();

    // format rupiah only for .rupiah inputs
    document.querySelectorAll('input.rupiah').forEach(input => {
      input.addEventListener('input', function() {
        const only = this.value.replace(/[^0-9]/g, '');
        this.value = only ? new Intl.NumberFormat('id-ID').format(only) : '';
      });
      // strip formatting before any programmatic read (we read by toNumber helper)
    });

    // 
    const nisabProfesi = document.getElementById('nisab_profesi');
    const berasProfesiWrapper = document.getElementById('beras_profesi_wrapper');
    function toggleBerasProfesi(){
      berasProfesiWrapper.classList.toggle('hidden', nisabProfesi.value !== 'beras');
      calculateProfesi();
    }
    nisabProfesi.addEventListener('change', toggleBerasProfesi);
    document.addEventListener('DOMContentLoaded', toggleBerasProfesi);

    // manual checkboxes
    [['profesi','profesi_manual','profesi_manual_checkbox'], ['maal','maal_manual','maal_manual_checkbox'], ['perniagaan','perniagaan_manual','perniagaan_manual_checkbox']].forEach(([prefix, id_section, id_chk])=>{
      const chk = document.getElementById(id_chk);
      const sec = document.getElementById(id_section);
      chk?.addEventListener('change', ()=> {
        if (chk.checked) sec.classList.remove('hidden'); else sec.classList.add('hidden');
        calculateAll();
      });
    });

    // live update kalkulasi zakat penghasilan / profesi
    function calculateProfesi(){
      const penghasilan = toNumber(document.getElementById('penghasilan_profesi').value);
      const tambahan = toNumber(document.getElementById('tambahan_profesi').value);
      const pengeluaran = toNumber(document.getElementById('pengeluaran_profesi').value);
      const bulan = Number(document.getElementById('bulan_profesi').value) || 1;
      const metode = document.getElementById('nisab_profesi').value;
      const hargaEmasPerGram = Number("{{ $goldPriceInit ?? session('zakat_harga_emas') ?? 0 }}") || 0;
      const hargaBeras = toNumber(document.getElementById('harga_beras_profesi')?.value || '');

      const manualChecked = document.getElementById('profesi_manual_checkbox').checked;
      const manualVal = toNumber(document.getElementById('manual_jumlah_profesi')?.value || '');

        // Nisab 
          let total = (penghasilan + tambahan - pengeluaran) * bulan;
          if (total < 0) total = 0;

          let nisab = 0;
          let dasarText = '';

          if (metode === 'emas') {
            nisab = (85 * hargaEmasPerGram) / 12; // monthly threshold (kept consistent)
            dasarText = `Nisab emas 85gr (Rp ${fmtRupiah(hargaEmasPerGram)}/gr) — per bulan`;
          } else {
            // LOGIKA BERAS: 522 kg setara gabah/beras per panen (atau setara per bulan untuk profesi qiyas)
            // Kita asumsikan input harga beras per Kg.
            nisab = hargaBeras * 522;
            dasarText = `Nisab beras 522 kg (Rp ${fmtRupiah(hargaBeras)}/kg per tahun)`;
          }

          // Penentu wajib zakat
          let wajib = false; 
          // Jika penghasilan > nisab (baik itu nisab emas atau beras), maka wajib.
          if (total >= nisab) wajib = true;

          // PERHITUNGAN NOMINAL 
          let hasil = 0;
          if (manualChecked && manualVal > 0) {
            hasil = manualVal;
          } else {
            if (wajib) {
              // Zakat profesi tetap 2.5% dari total penghasilan, kedua metode nisab
              hasil = Math.round(total * 0.025);
            }
          }

          // update UI and save
          updateResultPanel('profesi', dasarText, total, nisab, wajib, hasil);
          saveLiveSession({
            jenis: 'profesi',
            total, nisab, metode,
            hargaEmasPerGram, hargaBeras,
            hasil
          });
    }

    // live update kalkulasi dan logika kalkulasi zakat maal
    function calculateMaal(){
      const harta = toNumber(document.getElementById('harta_maal')?.value || '');
      const uang = toNumber(document.getElementById('uang_maal')?.value || '');
      const lainnya = toNumber(document.getElementById('lainnya_maal')?.value || '');
      const hutang = toNumber(document.getElementById('hutang_maal')?.value || '');

      const hargaEmasPerGram = Number("{{ $goldPriceInit ?? session('zakat_harga_emas') ?? 0 }}") || 0;
      const manualChecked = document.getElementById('maal_manual_checkbox').checked;
      const manualVal = toNumber(document.getElementById('manual_jumlah_maal')?.value || '');

      let total = harta + uang + lainnya - hutang;
      if (total < 0) total = 0;

      const nisab = 85 * hargaEmasPerGram;
      let wajib = total >= nisab;
      let hasil = 0;
      if (manualChecked && manualVal > 0) hasil = manualVal;
      else if (wajib) hasil = Math.round(total * 0.025);

      updateResultPanel('maal', `Nisab emas 85 gr (Rp ${fmtRupiah(hargaEmasPerGram)}/gr)`, total, nisab, wajib, hasil);
      saveLiveSession({ jenis: 'maal', total, nisab, hasil, hargaEmasPerGram });
    }

    // live update kalkulasi dan logika kalkulasi zakat perniagaan
    function calculatePerniagaan(){
      const modal = toNumber(document.getElementById('modal_perniagaan')?.value || '');
      const pendapatan = toNumber(document.getElementById('pendapatan_perniagaan')?.value || '');
      const piutang = toNumber(document.getElementById('piutang_perniagaan')?.value || '');
      const barang = toNumber(document.getElementById('barang_perniagaan')?.value || '');
      const hutang = toNumber(document.getElementById('hutang_perniagaan')?.value || '');
      const pengeluaran = toNumber(document.getElementById('pengeluaran_perniagaan')?.value || '');

      const hargaEmasPerGram = Number("{{ $goldPriceInit ?? session('zakat_harga_emas') ?? 0 }}") || 0;
      const manualChecked = document.getElementById('perniagaan_manual_checkbox').checked;
      const manualVal = toNumber(document.getElementById('manual_jumlah_perniagaan')?.value || '');

      let total = modal + pendapatan + piutang + barang - hutang - pengeluaran;
      if (total < 0) total = 0;

      const nisab = 85 * hargaEmasPerGram;
      let wajib = total >= nisab;
      let hasil = 0;
      if (manualChecked && manualVal > 0) hasil = manualVal;
      else if (wajib) hasil = Math.round(total * 0.025);

      updateResultPanel('perniagaan', `Nisab emas 85 gr (Rp ${fmtRupiah(hargaEmasPerGram)}/gr)`, total, nisab, wajib, hasil);
      saveLiveSession({ jenis: 'perniagaan', total, nisab, hasil, hargaEmasPerGram });
    }

    function calculateAll(){
      const active = document.querySelector('.tab-content:not(.hidden)');
      if (!active) return;
      if (active.id === 'tab-profesi') calculateProfesi();
      if (active.id === 'tab-maal') calculateMaal();
      if (active.id === 'tab-perniagaan') calculatePerniagaan();

      // persist form inputs locally
      localStorage.setItem('lastTab', document.querySelector('.tab-btn.bg-emerald-100')?.dataset.tab || 'profesi');
    }

    // attach realtime listeners
    [
      // profesi
      'email_profesi','penghasilan_profesi','tambahan_profesi','pengeluaran_profesi','bulan_profesi','harga_beras_profesi','manual_jumlah_profesi',
      // maal
      'email_maal','harta_maal','uang_maal','lainnya_maal','hutang_maal','manual_jumlah_maal',
      // perniagaan
      'email_perniagaan','modal_perniagaan','pendapatan_perniagaan','barang_perniagaan','piutang_perniagaan','hutang_perniagaan','pengeluaran_perniagaan','manual_jumlah_perniagaan'
    ].forEach(id=>{
      const el = document.getElementById(id);
      if (!el) return;
      el.addEventListener('input', calculateAll);
      el.addEventListener('change', calculateAll);
    });

    // update panel
    function updateResultPanel(jenis, dasar, total, nisab, wajib, hasil){
      document.getElementById('out_jenis').textContent = jenis.charAt(0).toUpperCase() + jenis.slice(1);
      document.getElementById('out_dasar').textContent = dasar;
      document.getElementById('out_total').textContent = 'Rp ' + fmtRupiah(total);
      document.getElementById('out_nisab').textContent = 'Rp ' + fmtRupiah(nisab);
      document.getElementById('out_status').textContent = wajib ? 'Wajib zakat' : 'Belum wajib zakat';
      document.getElementById('out_jumlah').textContent = 'Rp ' + fmtRupiah(hasil);

      // UPDATE KE FORM BAYAR (Agar data terkirim ke Controller)
      document.getElementById('pay_jenis').value = jenis;
      document.getElementById('pay_jumlah').value = hasil;
      
      // Ambil Nama & Email sesuai tab yang aktif
      let namaInput = document.getElementById('nama_' + jenis)?.value || 'Hamba Allah';
      let emailInput = document.getElementById('email_' + jenis)?.value || '';

      document.getElementById('pay_nama').value = namaInput;
      document.getElementById('pay_email').value = emailInput;

      // Validasi sederhana: Tombol mati jika hasil 0 atau Email kosong (opsional, tapi disarankan)
      // document.getElementById('btnPay').disabled = hasil <= 0 || emailInput === '';
      document.getElementById('btnPay').disabled = hasil <= 0;
    }

    // live save session - separate key
    async function saveLiveSession(payload){
      // payload contains jenis,total,nisab,hasil,...
      try {
        await fetch('/zakat/live-update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ live: payload })
        });
      } catch (e) {
        // silent
      }
    }

    // initial calc
    document.addEventListener('DOMContentLoaded', () => {
      // ensure name input not formatted
      document.getElementById('nama_profesi').classList.remove('rupiah');
      calculateAll();
    });

    // submit pay form: let server side use session or posted jumlah
    document.getElementById('payForm')?.addEventListener('submit', function(e){
      // allow normal post to zakat.store
    });
  </script>
</x-guest-layout>