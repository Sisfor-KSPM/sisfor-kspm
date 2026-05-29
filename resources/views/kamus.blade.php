@extends('layouts.app')

@section('title', 'KSPM SV IPB — Kamus Pasar Modal')

@section('styles')
.alpha-btn{padding:5px 10px;border-radius:7px;font-size:0.78rem;font-weight:700;border:1.5px solid #d0d5e8;background:#fff;cursor:pointer;transition:all 0.15s;color:#5a6080}
.alpha-btn:hover,.alpha-btn.active{background:#1a2fb5;color:#fff;border-color:#1a2fb5}
.kamus-card{background:#fff;border:1.5px solid #d0d5e8;border-radius:14px;padding:18px 20px;transition:all 0.2s}
.kamus-card:hover{border-color:#1a2fb5;background:#f7f9ff}
.kamus-term{font-weight:800;font-size:0.95rem;color:#0d0f1a;margin-bottom:4px}
.kamus-type{display:inline-block;font-size:0.62rem;font-weight:700;background:#e8ecfb;color:#1a2fb5;padding:2px 8px;border-radius:20px;margin-bottom:6px}
.kamus-def{font-size:0.82rem;color:#5a6080;line-height:1.7}
@endsection

@section('content')
<section class="bg-[#f7f8fc] pt-[140px] pb-24 min-h-screen">
  <div class="max-w-[1200px] mx-auto px-10">
    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">Kamus</div>
    <h1 class="text-[clamp(2rem,4vw,3rem)] font-medium text-[#0d0f1a] leading-[1.1] mb-2">Kamus Pasar Modal A–Z</h1>
    <p class="text-[0.95rem] text-[#5a6080] leading-[1.8] max-w-[540px] mb-6">Ratusan istilah penting dalam dunia bursa efek dan investasi — mudah dipahami.</p>

    <div class="relative max-w-[440px] mb-5">
      <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#5a6080]">🔍</span>
      <input id="kamus-search" class="w-full pl-10 pr-4 py-3 border-[1.5px] border-[#d0d5e8] rounded-[10px] text-[0.875rem] bg-white outline-none focus:border-[#1a2fb5] shadow-sm" type="text" placeholder="Cari istilah pasar modal..." oninput="filterKamus()">
    </div>

    <div class="flex flex-wrap gap-1.5 mb-7" id="alpha-tabs"></div>
    <div class="text-[0.78rem] text-[#5a6080] mb-4" id="kamus-count"></div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3" id="kamus-grid"></div>
  </div>
</section>

<script>
var kamusData=[
  {term:'Aksi Korporasi',type:'Umum',def:'Keputusan strategis yang diambil manajemen perusahaan yang berdampak pada harga saham, seperti stock split, right issue, atau merger.'},
  {term:'Analisis Fundamental',type:'Analisis',def:'Metode evaluasi saham dengan menganalisis kondisi keuangan, manajemen, industri, dan prospek bisnis perusahaan.'},
  {term:'Analisis Teknikal',type:'Analisis',def:'Metode evaluasi saham menggunakan data historis harga dan volume perdagangan untuk memprediksi pergerakan harga di masa depan.'},
  {term:'Auto Reject',type:'Mekanisme',def:'Penolakan otomatis oleh sistem BEI ketika harga saham naik atau turun melampaui batas yang ditentukan dalam satu hari perdagangan.'},
  {term:'Bear Market',type:'Kondisi Pasar',def:'Kondisi pasar ketika harga saham mengalami penurunan signifikan (lebih dari 20%) dalam jangka waktu yang berkelanjutan.'},
  {term:'Blue Chip',type:'Kategori',def:'Saham perusahaan besar, mapan, dan memiliki reputasi kuat dengan kinerja keuangan yang stabil dan konsisten.'},
  {term:'Buyback',type:'Aksi Korporasi',def:'Pembelian kembali saham yang telah diterbitkan oleh perusahaan itu sendiri di pasar sekunder.'},
  {term:'Capitalization (Market Cap)',type:'Valuasi',def:'Nilai total pasar dari saham beredar suatu perusahaan, dihitung dari harga saham dikalikan jumlah lembar saham beredar.'},
  {term:'Dividen',type:'Return',def:'Pembagian keuntungan perusahaan kepada pemegang saham, umumnya berupa uang tunai atau saham tambahan.'},
  {term:'EPS (Earnings Per Share)',type:'Fundamental',def:'Laba bersih perusahaan dibagi jumlah saham beredar. Indikator profitabilitas per lembar saham.'},
  {term:'EBITDA',type:'Fundamental',def:'Earnings Before Interest, Taxes, Depreciation, and Amortization. Ukuran kinerja operasional perusahaan sebelum beban non-kas.'},
  {term:'Flag Pattern',type:'Teknikal',def:'Pola grafik yang menyerupai bendera, mengindikasikan konsolidasi sementara sebelum berlanjutnya tren sebelumnya.'},
  {term:'Free Float',type:'Struktur',def:'Proporsi saham perusahaan yang tersedia untuk diperdagangkan secara bebas di pasar, tidak termasuk saham yang dikunci oleh pemegang strategis.'},
  {term:'Gap',type:'Teknikal',def:'Jarak antara harga penutupan hari sebelumnya dan harga pembukaan hari berikutnya pada grafik saham.'},
  {term:'Good Till Cancelled (GTC)',type:'Order',def:'Jenis order beli atau jual yang tetap berlaku hingga dieksekusi atau dibatalkan secara manual.'},
  {term:'Head and Shoulders',type:'Teknikal',def:'Pola grafik teknikal yang mengindikasikan pembalikan tren dari bullish ke bearish, membentuk pola seperti kepala dan dua bahu.'},
  {term:'IHSG',type:'Indeks',def:'Indeks Harga Saham Gabungan — indeks yang mengukur kinerja keseluruhan pasar saham Indonesia di Bursa Efek Indonesia.'},
  {term:'IPO (Initial Public Offering)',type:'Pasar Primer',def:'Penawaran saham perdana kepada publik ketika sebuah perusahaan pertama kali mencatatkan sahamnya di bursa efek.'},
  {term:'Kapitalisasi Pasar',type:'Valuasi',def:'Total nilai pasar dari seluruh saham yang beredar suatu perusahaan. Klasifikasi: Large Cap (>10T), Mid Cap (1-10T), Small Cap (<1T).'},
  {term:'Likuiditas',type:'Fundamental',def:'Kemampuan suatu aset untuk dikonversi menjadi uang tunai dengan cepat tanpa mempengaruhi harga secara signifikan.'},
  {term:'Lot',type:'Unit',def:'Satuan perdagangan saham di BEI. 1 lot = 100 lembar saham.'},
  {term:'MACD',type:'Indikator Teknikal',def:'Moving Average Convergence Divergence — indikator teknikal yang menunjukkan hubungan antara dua moving average harga saham.'},
  {term:'Moving Average',type:'Indikator Teknikal',def:'Rata-rata harga saham dalam periode waktu tertentu, digunakan untuk mengidentifikasi tren dan sinyal jual beli.'},
  {term:'Net Profit Margin',type:'Fundamental',def:'Persentase laba bersih terhadap pendapatan total. Mengukur seberapa efisien perusahaan mengubah penjualan menjadi keuntungan.'},
  {term:'OJK',type:'Regulasi',def:'Otoritas Jasa Keuangan — lembaga negara yang berfungsi mengatur dan mengawasi kegiatan di sektor jasa keuangan Indonesia.'},
  {term:'P/E Ratio (Price to Earnings)',type:'Valuasi',def:'Rasio harga saham terhadap laba per saham (EPS). Digunakan untuk menilai apakah saham mahal atau murah relatif terhadap laba perusahaan.'},
  {term:'P/BV Ratio (Price to Book Value)',type:'Valuasi',def:'Rasio harga saham terhadap nilai buku per saham. Nilai < 1 bisa mengindikasikan saham undervalued.'},
  {term:'Portfolio',type:'Investasi',def:'Kumpulan aset investasi yang dimiliki seseorang atau lembaga, seperti saham, obligasi, reksa dana, dan aset lainnya.'},
  {term:'Right Issue',type:'Aksi Korporasi',def:'Penerbitan saham baru oleh perusahaan yang ditawarkan terlebih dahulu kepada pemegang saham lama dengan harga tertentu.'},
  {term:'Return on Equity (ROE)',type:'Fundamental',def:'Rasio laba bersih terhadap ekuitas pemegang saham. Mengukur seberapa efisien perusahaan menggunakan modal dari pemegang saham.'},
  {term:'RSI (Relative Strength Index)',type:'Indikator Teknikal',def:'Indikator momentum yang mengukur kecepatan dan perubahan pergerakan harga. RSI > 70 = overbought, RSI < 30 = oversold.'},
  {term:'Saham',type:'Instrumen',def:'Bukti kepemilikan seseorang atau badan terhadap suatu perusahaan, memberikan hak atas dividen dan suara dalam RUPS.'},
  {term:'Stock Split',type:'Aksi Korporasi',def:'Pemecahan nilai nominal saham menjadi lebih kecil dengan rasio tertentu, sehingga jumlah lembar saham bertambah namun total nilai tidak berubah.'},
  {term:'Support',type:'Teknikal',def:'Level harga di mana saham cenderung berhenti turun karena banyaknya pembeli pada level tersebut.'},
  {term:'Teknikal Analisis',type:'Analisis',def:'Metode memprediksi pergerakan harga berdasarkan data historis, pola grafik, dan indikator teknikal.'},
  {term:'Undervalued',type:'Valuasi',def:'Kondisi di mana harga saham diperdagangkan di bawah nilai intrinsiknya, berpotensi menjadi peluang investasi menarik.'},
  {term:'Volume',type:'Perdagangan',def:'Jumlah total lembar saham yang diperdagangkan dalam periode waktu tertentu. Volume tinggi mengonfirmasi kekuatan suatu tren.'},
  {term:'Warrant',type:'Instrumen',def:'Efek yang memberikan hak kepada pemegangnya untuk membeli saham baru dari emiten pada harga dan waktu yang telah ditentukan.'},
  {term:'Yield',type:'Return',def:'Imbal hasil investasi, dinyatakan dalam persentase. Untuk saham: dividen yield = dividen per lembar / harga saham × 100%.'},
];
kamusData.sort(function(a,b){return a.term.localeCompare(b.term,'id');});

var _activeLetter='all';
var _searchQ='';

var alphaEl=document.getElementById('alpha-tabs');
var letters=['all'].concat('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split(''));
letters.forEach(function(l){
  var btn=document.createElement('button');
  btn.className='alpha-btn'+(l==='all'?' active':'');
  btn.textContent=l==='all'?'Semua':l;
  btn.onclick=function(){
    document.querySelectorAll('.alpha-btn').forEach(function(b){b.classList.remove('active');});
    btn.classList.add('active');
    _activeLetter=l;
    renderKamus();
  };
  alphaEl.appendChild(btn);
});

function filterKamus(){
  _searchQ=document.getElementById('kamus-search').value.toLowerCase();
  renderKamus();
}

function renderKamus(){
  var data=kamusData.filter(function(k){
    var letterOk=_activeLetter==='all'||k.term.charAt(0).toUpperCase()===_activeLetter;
    var searchOk=!_searchQ||k.term.toLowerCase().includes(_searchQ)||k.def.toLowerCase().includes(_searchQ);
    return letterOk&&searchOk;
  });
  var el=document.getElementById('kamus-grid');
  var cnt=document.getElementById('kamus-count');
  if(cnt)cnt.textContent='Menampilkan '+data.length+' dari '+kamusData.length+' istilah';
  if(!el)return;
  if(!data.length){
    el.innerHTML='<div class="col-span-full text-center py-12 text-[#5a6080]">Tidak ada istilah ditemukan.</div>';
    return;
  }
  el.innerHTML=data.map(function(k){
    return '<div class="kamus-card">'+
      '<div class="kamus-term">'+k.term+'</div>'+ 
      '<span class="kamus-type">'+k.type+'</span>'+ 
      '<div class="kamus-def">'+k.def+'</div>'+ 
    '</div>';
  }).join('');
}
renderKamus();
</script>
@endsection