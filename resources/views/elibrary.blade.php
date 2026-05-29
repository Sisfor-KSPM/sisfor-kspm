@extends('layouts.app')

@section('title', 'E-Library')

@section('content')

<section class="bg-white pt-[140px] pb-16">
  <div class="max-w-[1200px] mx-auto px-10">

    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">
      E-Library
    </div>

    <h1 class="text-[clamp(2rem,4vw,3.2rem)] font-medium text-[#0d0f1a] leading-[1.1] mb-3">
      Riset & Analisis KSPM
    </h1>

    <p class="text-[0.95rem] text-[#5a6080] leading-[1.8] max-w-[540px] mb-8">
      Koleksi laporan riset, analisis teknikal, dan market outlook dari tim analis KSPM SV IPB.
    </p>

    {{-- TABS --}}
    <div class="flex flex-wrap gap-2 mb-8">

      <button
        class="tab-btn bg-[#1a2fb5] text-white border-[#1a2fb5] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200"
        onclick="filterResearch('all', this)">
        Semua
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('weekly', this)">
        Weekly Research
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('equity', this)">
        Equity Research
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('outlook', this)">
        Market Outlook
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('casual', this)">
        Casual of the Day
      </button>

      <button
        class="tab-btn bg-white text-[#5a6080] border-[#d0d5e8] px-[18px] py-[7px] rounded-lg text-[0.82rem] font-semibold border-[1.5px] cursor-pointer transition-all duration-200 hover:bg-[#1a2fb5] hover:text-white hover:border-[#1a2fb5]"
        onclick="filterResearch('cme', this)">
        CME
      </button>

    </div>

    {{-- SEARCH --}}
    <div class="relative max-w-[360px] mb-8">

      <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#5a6080]">
        🔍
      </span>

      <input
        class="w-full pl-10 pr-4 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-[9px] text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5]"
        type="text"
        placeholder="Cari laporan riset..."
        id="research-search"
        oninput="searchResearch()"
      >
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5" id="research-grid"></div>

  </div>
</section>

{{-- RESEARCH MODAL --}}
<div
  class="modal-overlay fixed inset-0 z-[700] bg-black/70 backdrop-blur-[10px] overflow-y-auto hidden"
  id="modal-research">

  <div class="min-h-full flex items-center justify-center p-10">

    <div class="modal-box bg-white rounded-[22px] w-full max-w-[780px] relative shadow-[0_36px_90px_rgba(0,0,0,0.25)]">

      <div class="bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] p-10 text-white rounded-t-[22px] relative">

        <button
          class="absolute top-4 right-4 w-[34px] h-[34px] rounded-full bg-white/10 text-white cursor-pointer flex items-center justify-center hover:bg-white/20 border-none text-base"
          onclick="closeModal('research')">
          ✕
        </button>

        <div
          class="text-[0.65rem] font-bold uppercase tracking-[0.1em] text-white/50 mb-2"
          id="rm-type">
        </div>

        <div
          class="text-[1.6rem] font-extrabold mb-2.5 leading-[1.2]"
          id="rm-title">
        </div>

        <div
          class="text-[0.82rem] text-white/60"
          id="rm-meta">
        </div>

      </div>

      <div class="px-10 py-9">

        <div class="mb-6">
          <h4 class="font-bold text-[#0d0f1a] mb-2">
            Ringkasan
          </h4>

          <p class="text-[0.88rem] text-[#5a6080] leading-[1.8]" id="rm-summary"></p>
        </div>

        <div class="mb-6">
          <h4 class="font-bold text-[#0d0f1a] mb-2">
            Isi Laporan
          </h4>

          <p class="text-[0.88rem] text-[#5a6080] leading-[1.8]" id="rm-content"></p>
        </div>

      </div>

      <div class="flex gap-2.5 px-10 pb-9">

        <button
          class="flex items-center gap-2 px-6 py-3 rounded-[9px] font-bold text-[0.88rem] bg-[#1a2fb5] text-white border-none cursor-pointer hover:bg-[#1e38cc]"
          onclick="closeModal('research')">

          ⬇ Download PDF
        </button>

        <button
          class="px-6 py-3 rounded-[9px] font-semibold text-[0.88rem] border-[1.5px] border-[#d0d5e8] text-[#1c1f3a] bg-white cursor-pointer hover:border-[#1a2fb5] hover:text-[#1a2fb5]"
          onclick="closeModal('research')">

          Tutup
        </button>

      </div>

    </div>
  </div>
</div>

@endsection

@section('styles')
<style>

.research-card{
  transition:all .2s;
  cursor:pointer;
}

.research-card:hover{
  transform:translateY(-4px);
  box-shadow:0 14px 36px rgba(26,47,181,.1);
  border-color:#1a2fb5!important;
}

.modal-overlay{
  opacity:0;
  pointer-events:none;
  transition:all .25s ease;
}

.modal-overlay.open{
  opacity:1;
  pointer-events:auto;
}

.modal-overlay.open .modal-box{
  transform:translateY(0);
}

.modal-box{
  transform:translateY(20px);
  transition:all .25s ease;
}

</style>
@endsection

@section('scripts')
<script>

var researchData = [

  {
    type:'Weekly Research',
    cat:'weekly',
    title:'Market Update W15 2025 — IHSG Rebound',
    author:'Tim Riset KSPM',
    date:'14 April 2025',
    summary:'IHSG berhasil rebound ke level 7.300-an setelah tekanan jual mereda pekan sebelumnya.',
    content:'Analisis pergerakan IHSG, sektor-sektor outperform, serta rekomendasi saham pilihan minggu ini.',
    emoji:'📊'
  },

  {
    type:'Equity Research',
    cat:'equity',
    title:'BBCA: Defensive Play di Tengah Volatilitas',
    author:'Div. Riset',
    date:'10 April 2025',
    summary:'BBCA tetap menjadi pilihan utama sebagai saham defensif dengan fundamental solid.',
    content:'Analisis mendalam fundamental BBCA, valuasi, proyeksi laba, dan target harga.',
    emoji:'🏦'
  },

  {
    type:'Market Outlook',
    cat:'outlook',
    title:'Q2 2025 Investment Outlook',
    author:'Tim Analis',
    date:'1 April 2025',
    summary:'Proyeksi pasar modal Indonesia Q2 2025 dengan berbagai skenario makroekonomi.',
    content:'Analisis faktor makro, sektoral, dan rekomendasi alokasi portofolio untuk Q2 2025.',
    emoji:'🔮'
  }

];

var _resCat = 'all';
var _resSearch = '';

function filterResearch(cat, btn){

  _resCat = cat;

  document.querySelectorAll('.tab-btn').forEach(function(b){

    b.classList.remove(
      'bg-[#1a2fb5]',
      'text-white',
      'border-[#1a2fb5]'
    );

    b.classList.add(
      'bg-white',
      'text-[#5a6080]',
      'border-[#d0d5e8]'
    );
  });

  btn.classList.add(
    'bg-[#1a2fb5]',
    'text-white',
    'border-[#1a2fb5]'
  );

  btn.classList.remove(
    'bg-white',
    'text-[#5a6080]',
    'border-[#d0d5e8]'
  );

  renderResearch();
}

function searchResearch(){

  _resSearch = document
    .getElementById('research-search')
    .value
    .toLowerCase();

  renderResearch();
}

function renderResearch(){

  var el = document.getElementById('research-grid');

  if(!el) return;

  var data = researchData.filter(function(r){

    var catOk =
      _resCat === 'all' || r.cat === _resCat;

    var searchOk =
      !_resSearch ||
      r.title.toLowerCase().includes(_resSearch) ||
      r.type.toLowerCase().includes(_resSearch);

    return catOk && searchOk;
  });

  if(!data.length){

    el.innerHTML = `
      <div class="col-span-full text-center py-12 text-[#5a6080]">
        Tidak ada laporan ditemukan.
      </div>
    `;

    return;
  }

  el.innerHTML = data.map(function(r, i){

    return `
      <div
        class="research-card bg-white border border-[#d0d5e8] rounded-[18px] overflow-hidden"
        onclick="openResearch(${researchData.indexOf(r)})"
      >

        <div class="h-[120px] bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center text-[3rem]">
          ${r.emoji}
        </div>

        <div class="p-5">

          <div class="text-[0.68rem] font-bold text-[#1a2fb5] uppercase tracking-[0.06em] mb-1.5">
            ${r.type}
          </div>

          <div class="text-[0.92rem] font-extrabold text-[#0d0f1a] mb-1 leading-[1.3]">
            ${r.title}
          </div>

          <div class="text-[0.72rem] text-[#5a6080] mb-3">
            ${r.author} · ${r.date}
          </div>

          <p class="text-[0.82rem] text-[#5a6080] leading-[1.6] mb-4">
            ${r.summary}
          </p>

          <div class="flex gap-2">

            <button class="flex-1 py-2 rounded-lg text-[0.8rem] font-bold bg-[#e8ecfb] text-[#1a2fb5] border-none cursor-pointer hover:bg-[#1a2fb5] hover:text-white transition-all duration-200">

              Baca Selengkapnya
            </button>

          </div>

        </div>
      </div>
    `;

  }).join('');
}

renderResearch();

function openResearch(i){

  var r = researchData[i];

  document.getElementById('rm-type').textContent = r.type;
  document.getElementById('rm-title').textContent = r.title;
  document.getElementById('rm-meta').textContent = r.author + ' · ' + r.date;
  document.getElementById('rm-summary').textContent = r.summary;
  document.getElementById('rm-content').textContent = r.content;

  var modal = document.getElementById('modal-research');

  modal.classList.remove('hidden');

  setTimeout(function(){
    modal.classList.add('open');
  }, 10);
}

function closeModal(id){

  var modal = document.getElementById('modal-' + id);

  modal.classList.remove('open');

  setTimeout(function(){
    modal.classList.add('hidden');
  }, 250);
}

</script>
@endsection