@extends('layouts.user')

@section('page-title', 'Kalkulator Saham')
@section('page-breadcrumb', 'Tools Analisis')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Kalkulator Saham</div>
        <div class="section-sub text-sm text-gray-500">Tools analisis & kalkulasi investasi</div>
    </div>
</div>

<div class="tab-bar flex gap-1.5 mb-5 flex-wrap bg-slate-100 p-1.5 rounded-xl">
    <button class="tab-btn active px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white shadow-sm transition" data-track-feature="calculator_tab_average_down" onclick="switchTab('avg', this)">📉 Average Down</button>
    <button class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-200 transition" data-track-feature="calculator_tab_profit_loss" onclick="switchTab('pl', this)">📊 Profit / Loss</button>
    <button class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-200 transition" data-track-feature="calculator_tab_bep" onclick="switchTab('bep', this)">🎯 Target & BEP</button>
    <button class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-200 transition" data-track-feature="calculator_tab_fee" onclick="switchTab('fee', this)">💸 Fee Broker</button>
    <button class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-200 transition" data-track-feature="calculator_tab_dividen" onclick="switchTab('dividen', this)">💰 Dividen</button>
    <button class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-200 transition" data-track-feature="calculator_tab_valuation" onclick="switchTab('valuation', this)">🔍 Valuasi Saham</button>
</div>

<div class="tab-content block" id="tab-avg">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Kalkulator Average Down</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Hitung harga rata-rata setelah menambah posisi.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Beli Awal (Rp)</label><input id="avg-harga-awal" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lot Awal</label><input id="avg-lot-awal" class="inp" type="number" placeholder="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Beli Baru (Rp)</label><input id="avg-harga-baru" class="inp" type="number" placeholder="4500"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lot Baru</label><input id="avg-lot-baru" class="inp" type="number" placeholder="10"></div>
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_average" onclick="hitungAverageDown()">Hitung Average</button>
        </div>
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div class="font-bold mb-3 text-gray-900">📊 Hasil Kalkulasi</div>
                <div class="text-[0.82rem] text-gray-600 space-y-2 mb-4">
                    <div class="flex justify-between border-b pb-1.5"><span>Total Lembar Saham:</span><span id="res-avg-total-saham" class="font-bold text-gray-900">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Total Modal Investasi:</span><span id="res-avg-total-modal" class="font-bold text-gray-900">-</span></div>
                    <div class="flex justify-between border-b pb-1.5 bg-blue-50 p-1.5 rounded"><span>Harga Rata-Rata Baru:</span><span id="res-avg-harga-baru" class="font-bold text-blue-700 text-sm">-</span></div>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 text-[0.78rem] text-gray-500">
                💡 <strong>Tips:</strong> Average down efektif untuk saham berfundamental kuat saat harganya sedang mengalami diskon teknikal pasar.
            </div>
        </div>
    </div>
</div>

<div class="tab-content hidden" id="tab-pl">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Kalkulator Profit / Loss</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Hitung keuntungan atau kerugian posisi saham.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Beli (Rp)</label><input id="pl-harga-beli" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Jual (Rp)</label><input id="pl-harga-jual" class="inp" type="number" placeholder="5500"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Lot</label><input id="pl-lot" class="inp" type="number" placeholder="10"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Fee Broker (%)</label><input id="pl-fee" class="inp" type="number" placeholder="0.15" value="0.15" step="0.01"></div>
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_profit_loss" onclick="hitungProfitLoss()">Hitung Profit / Loss</button>
        </div>
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div class="font-bold mb-3 text-gray-900">📊 Hasil Analisis Keuntungan</div>
                <div class="text-[0.82rem] text-gray-600 space-y-2">
                    <div class="flex justify-between border-b pb-1.5"><span>Nilai Pembelian (+Fee):</span><span id="res-pl-beli" class="font-bold">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Nilai Penjualan (-Fee):</span><span id="res-pl-jual" class="font-bold">-</span></div>
                    <div class="flex justify-between border-b pb-1.5 p-1.5 rounded" id="res-pl-wrapper">
                        <span id="res-pl-status">Profit/Loss Bersih:</span>
                        <span id="res-pl-nominal" class="font-bold text-sm">-</span>
                    </div>
                    <div class="flex justify-between border-b pb-1.5"><span>Persentase Net Return:</span><span id="res-pl-persen" class="font-bold">-</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-content hidden" id="tab-bep">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Target & Break Even Point</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Hitung target harga dan BEP dengan fee broker.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Beli (Rp)</label><input id="bep-harga-beli" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Lot</label><input id="bep-lot" class="inp" type="number" placeholder="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Fee Beli (%)</label><input id="bep-fee-beli" class="inp" type="number" placeholder="0.15" value="0.15" step="0.01"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Fee Jual + Pajak (%)</label><input id="bep-fee-jual" class="inp" type="number" placeholder="0.25" value="0.25" step="0.01"></div>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Target Return (%)</label><input id="bep-target" class="inp" type="number" placeholder="10" value="10">
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_bep" onclick="hitungBEP()">Hitung BEP</button>
        </div>
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div class="font-bold mb-3 text-gray-900">🎯 Hasil Target Penjualan</div>
                <div class="text-[0.82rem] text-gray-600 space-y-2">
                    <div class="flex justify-between border-b pb-1.5 bg-gray-50 p-1.5 rounded"><span>Minimal Harga BEP (Balik Modal):</span><span id="res-bep-harga" class="font-bold text-gray-900">-</span></div>
                    <div class="flex justify-between border-b pb-1.5 bg-blue-50 p-1.5 rounded"><span>Harga Jual Target Sasaran:</span><span id="res-bep-target-harga" class="font-bold text-blue-700 text-sm">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Estimasi Profit Bersih Target:</span><span id="res-bep-estimasi-profit" class="font-bold text-green-600">-</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-content hidden" id="tab-fee">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Simulasi Fee Transaksi</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Estimasi total biaya transaksi beli & jual saham.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Saham (Rp)</label><input id="fee-harga" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Lot</label><input id="fee-lot" class="inp" type="number" placeholder="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Fee Beli (%)</label><input id="fee-beli-pct" class="inp" type="number" placeholder="0.15" value="0.15" step="0.01"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Fee Jual + PPh (%)</label><input id="fee-jual-pct" class="inp" type="number" placeholder="0.25" value="0.25" step="0.01"></div>
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_total_fee" onclick="hitungSimulasiFee()">Kalkulasi Total Fee</button>
        </div>
        <div class="card p-6">
            <div class="font-bold mb-3 text-gray-900">💸 Rincian Beban Transaksi</div>
            <div class="text-[0.82rem] text-gray-600 space-y-2">
                <div class="flex justify-between border-b pb-1.5"><span>Nilai Bersih Saham (Murni):</span><span id="res-fee-murni">-</span></div>
                <div class="flex justify-between border-b pb-1.5"><span>Nominal Fee Transaksi Beli:</span><span id="res-fee-beli-nom" class="text-red-500">-</span></div>
                <div class="flex justify-between border-b pb-1.5"><span>Nominal Fee Transaksi Jual:</span><span id="res-fee-jual-nom" class="text-red-500">-</span></div>
                <div class="flex justify-between border-b pb-1.5 bg-slate-100 p-1.5 rounded"><span>Total Akumulasi Fee (Beli + Jual):</span><span id="res-fee-total-akumulasi" class="font-bold text-gray-900">-</span></div>
            </div>
        </div>
    </div>
</div>

<div class="tab-content hidden" id="tab-dividen">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Kalkulator Dividen</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Estimasi dividen yang diterima dari kepemilikan saham.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Saham (Rp)</label><input id="div-harga" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Lot</label><input id="div-lot" class="inp" type="number" placeholder="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">DPS — Dividen/Saham (Rp)</label><input id="div-dps" class="inp" type="number" placeholder="200"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Pajak Dividen (%)</label><input id="div-pajak" class="inp" type="number" placeholder="10" value="10"></div>
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_dividend_neto" onclick="hitungDividen()">Hitung Dividen Neto</button>
        </div>
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div class="font-bold mb-3 text-gray-900">💰 Estimasi Pendapatan Dividen</div>
                <div class="text-[0.82rem] text-gray-600 space-y-2">
                    <div class="flex justify-between border-b pb-1.5"><span>Dividen Kotor (Bruto):</span><span id="res-div-bruto">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Potongan Pajak Dividen:</span><span id="res-div-pajak-nom" class="text-red-500">-</span></div>
                    <div class="flex justify-between border-b pb-1.5 bg-emerald-50 p-1.5 rounded"><span>Total Net Dividen (Diterima):</span><span id="res-div-neto" class="font-bold text-emerald-700 text-sm">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Yield Dividen Tahunan:</span><span id="res-div-yield" class="font-bold text-gray-900">-</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-content hidden" id="tab-valuation">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card p-6">
            <div class="font-bold text-base mb-1 text-gray-900">Valuasi Saham (PER & PBV)</div>
            <div class="text-[0.8rem] text-gray-500 mb-5">Analisis valuasi sederhana berdasarkan rasio fundamental.</div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Harga Saham (Rp)</label><input id="val-harga" class="inp" type="number" placeholder="5000"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">EPS — Laba/Saham (Rp)</label><input id="val-eps" class="inp" type="number" placeholder="500"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Book Value/Saham (Rp)</label><input id="val-bv" class="inp" type="number" placeholder="2500"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">PER Industri (x)</label><input id="val-per-ind" class="inp" type="number" placeholder="15" value="15"></div>
            </div>
            <button class="btn btn-primary w-full justify-center" data-track-calculator="calculate_valuation" onclick="hitungValuasi()">Hitung Valuasi</button>
        </div>
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <div class="font-bold mb-3 text-gray-900">🔍 Hasil Pengukuran Valuasi</div>
                <div class="text-[0.82rem] text-gray-600 space-y-2 mb-4">
                    <div class="flex justify-between border-b pb-1.5"><span>Rasio PER Perusahaan:</span><span id="res-val-per" class="font-bold">-</span></div>
                    <div class="flex justify-between border-b pb-1.5"><span>Rasio PBV Perusahaan:</span><span id="res-val-pbv" class="font-bold">-</span></div>
                    <div class="flex justify-between border-b pb-1.5 p-1.5 rounded text-center items-center justify-center font-bold text-sm" id="res-val-status-wrapper">
                        Status Valuasi: &nbsp;<span id="res-val-status">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Helper Fungsi Format Rupiah
function formatRupiah(angka) {
    if (isNaN(angka) || angka === null || !isFinite(angka)) return "Rp 0";
    return "Rp " + Math.round(angka).toLocaleString('id-ID');
}

// Fungsi Tab System
function switchTab(tabId, btnElement) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('block');
        tab.classList.add('hidden');
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
        btn.classList.add('text-gray-500');
    });
    
    document.getElementById('tab-' + tabId).classList.remove('hidden');
    document.getElementById('tab-' + tabId).classList.add('block');
    
    btnElement.classList.remove('text-gray-500');
    btnElement.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
}

// 1. Logika Average Down
function hitungAverageDown() {
    const hgAwal = parseFloat(document.getElementById('avg-harga-awal').value) || 0;
    const lotAwal = parseFloat(document.getElementById('avg-lot-awal').value) || 0;
    const hgBaru = parseFloat(document.getElementById('avg-harga-baru').value) || 0;
    const lotBaru = parseFloat(document.getElementById('avg-lot-baru').value) || 0;

    const totalLembar = (lotAwal + lotBaru) * 100;
    const totalModal = (hgAwal * lotAwal * 100) + (hgBaru * lotBaru * 100);
    const avgBaru = totalLembar > 0 ? (totalModal / totalLembar) : 0;

    document.getElementById('res-avg-total-saham').textContent = totalLembar.toLocaleString('id-ID') + " lembar (" + (lotAwal + lotBaru) + " Lot)";
    document.getElementById('res-avg-total-modal').textContent = formatRupiah(totalModal);
    document.getElementById('res-avg-harga-baru').textContent = formatRupiah(avgBaru);
}

// 2. Logika Profit / Loss
function hitungProfitLoss() {
    const beli = parseFloat(document.getElementById('pl-harga-beli').value) || 0;
    const jual = parseFloat(document.getElementById('pl-harga-jual').value) || 0;
    const lot = parseFloat(document.getElementById('pl-lot').value) || 0;
    const feePct = (parseFloat(document.getElementById('pl-fee').value) || 0) / 100;

    const nilaiBeliMurni = beli * lot * 100;
    const nilaiJualMurni = jual * lot * 100;
    
    const totalBeli = nilaiBeliMurni * (1 + feePct);
    const totalJual = nilaiJualMurni * (1 - feePct);
    const netProfitLoss = totalJual - totalBeli;
    const returnPct = totalBeli > 0 ? (netProfitLoss / totalBeli) * 100 : 0;

    document.getElementById('res-pl-beli').textContent = formatRupiah(totalBeli);
    document.getElementById('res-pl-jual').textContent = formatRupiah(totalJual);
    document.getElementById('res-pl-nominal').textContent = formatRupiah(netProfitLoss);
    document.getElementById('res-pl-persen').textContent = returnPct.toFixed(2) + "%";

    const wrapper = document.getElementById('res-pl-wrapper');
    if (netProfitLoss >= 0) {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-green-50 p-1.5 rounded text-green-700";
        document.getElementById('res-pl-status').textContent = "Profit Bersih:";
    } else {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-red-50 p-1.5 rounded text-red-700";
        document.getElementById('res-pl-status').textContent = "Loss Bersih:";
    }
}

// 3. Logika BEP & Target Price
function hitungBEP() {
    const beli = parseFloat(document.getElementById('bep-harga-beli').value) || 0;
    const feeBeli = (parseFloat(document.getElementById('bep-fee-beli').value) || 0) / 100;
    const feeJual = (parseFloat(document.getElementById('bep-fee-jual').value) || 0) / 100;
    const targetPct = (parseFloat(document.getElementById('bep-target').value) || 0) / 100;
    const lot = parseFloat(document.getElementById('bep-lot').value) || 0;

    // Rumus BEP memperhitungkan fee dua arah agar tidak boncos
    const hargaBEP = beli * (1 + feeBeli) / (1 - feeJual);
    const hargaTarget = hargaBEP * (1 + targetPct);
    
    const estimasiProfit = ((hargaTarget * lot * 100) * (1 - feeJual)) - ((beli * lot * 100) * (1 + feeBeli));

    document.getElementById('res-bep-harga').textContent = formatRupiah(hargaBEP) + " / lbr";
    document.getElementById('res-bep-target-harga').textContent = formatRupiah(hargaTarget) + " / lbr";
    document.getElementById('res-bep-estimasi-profit').textContent = formatRupiah(estimasiProfit);
}

// 4. Logika Simulasi Fee Broker
function hitungSimulasiFee() {
    const harga = parseFloat(document.getElementById('fee-harga').value) || 0;
    const lot = parseFloat(document.getElementById('fee-lot').value) || 0;
    const pctBeli = (parseFloat(document.getElementById('fee-beli-pct').value) || 0) / 100;
    const pctJual = (parseFloat(document.getElementById('fee-jual-pct').value) || 0) / 100;

    const nilaiMurni = harga * lot * 100;
    const nominalBeli = nilaiMurni * pctBeli;
    const nominalJual = nilaiMurni * pctJual;
    const akumulasi = nominalBeli + nominalJual;

    document.getElementById('res-fee-murni').textContent = formatRupiah(nilaiMurni);
    document.getElementById('res-fee-beli-nom').textContent = formatRupiah(nominalBeli);
    document.getElementById('res-fee-jual-nom').textContent = formatRupiah(nominalJual);
    document.getElementById('res-fee-total-akumulasi').textContent = formatRupiah(akumulasi);
}

// 5. Logika Dividen
function hitungDividen() {
    const harga = parseFloat(document.getElementById('div-harga').value) || 1;
    const lot = parseFloat(document.getElementById('div-lot').value) || 0;
    const dps = parseFloat(document.getElementById('div-dps').value) || 0;
    const pajakPct = (parseFloat(document.getElementById('div-pajak').value) || 0) / 100;

    const bruto = dps * lot * 100;
    const pajak = bruto * pajakPct;
    const neto = bruto - pajak;
    const yieldPct = ((dps) / harga) * 100;

    document.getElementById('res-div-bruto').textContent = formatRupiah(bruto);
    document.getElementById('res-div-pajak-nom').textContent = formatRupiah(pajak);
    document.getElementById('res-div-neto').textContent = formatRupiah(neto);
    document.getElementById('res-div-yield').textContent = yieldPct.toFixed(2) + "%";
}

// 6. Logika Valuasi Saham
function hitungValuasi() {
    const harga = parseFloat(document.getElementById('val-harga').value) || 0;
    const eps = parseFloat(document.getElementById('val-eps').value) || 0;
    const bv = parseFloat(document.getElementById('val-bv').value) || 0;
    const perInd = parseFloat(document.getElementById('val-per-ind').value) || 0;

    const per = eps > 0 ? (harga / eps) : 0;
    const pbv = bv > 0 ? (harga / bv) : 0;

    document.getElementById('res-val-per').textContent = per > 0 ? per.toFixed(2) + "x" : "-";
    document.getElementById('res-val-pbv').textContent = pbv > 0 ? pbv.toFixed(2) + "x" : "-";

    const wrapper = document.getElementById('res-val-status-wrapper');
    const statusText = document.getElementById('res-val-status');

    if (per === 0 || pbv === 0) {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-gray-100 p-1.5 rounded text-gray-700 font-bold text-sm";
        statusText.textContent = "Data tidak valid";
    } else if (per < 10 && pbv < 1) {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-green-100 p-1.5 rounded text-green-700 font-bold text-sm";
        statusText.textContent = "Sangat Murah (Undervalued)";
    } else if (per <= 18) {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-blue-100 p-1.5 rounded text-blue-700 font-bold text-sm";
        statusText.textContent = "Harga Wajar (Fair Value)";
    } else {
        wrapper.className = "flex justify-between border-b pb-1.5 bg-orange-100 p-1.5 rounded text-orange-700 font-bold text-sm";
        statusText.textContent = "Mahal (Overvalued)";
    }
}
</script>
@endpush
