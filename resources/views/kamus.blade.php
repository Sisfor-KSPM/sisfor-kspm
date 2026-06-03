@extends('layouts.app')

@section('title', 'KSPM SV IPB — Kamus Pasar Modal')

@section('styles')
<style>
.alpha-btn{padding:5px 10px;border-radius:7px;font-size:0.78rem;font-weight:700;border:1.5px solid #d0d5e8;background:#fff;cursor:pointer;transition:all 0.15s;color:#5a6080}
.alpha-btn:hover,.alpha-btn.active{background:#1a2fb5;color:#fff;border-color:#1a2fb5}
.kamus-card{background:#fff;border:1.5px solid #d0d5e8;border-radius:14px;padding:18px 20px;transition:all 0.2s}
.kamus-card:hover{border-color:#1a2fb5;background:#f7f9ff}
.kamus-term{font-weight:800;font-size:0.95rem;color:#0d0f1a;margin-bottom:4px}
.kamus-type{display:inline-block;font-size:0.62rem;font-weight:700;background:#e8ecfb;color:#1a2fb5;padding:2px 8px;border-radius:20px;margin-bottom:6px}
.kamus-def{font-size:0.82rem;color:#5a6080;line-height:1.7}
</style>
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
// Mengambil data dinamis ter-update dari model database Eloquent Laravel
var dbData = @json($terms);

// Memetakan field database Indonesia ke dalam struktur object JavaScript agar komponen pencarian tidak rusak
var kamusData = dbData.map(function(item) {
    return {
        id: item.id,
        term: item.istilah,
        type: item.kategori,
        def: item.definisi
    };
});

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
    return '<div class="kamus-card" data-track-dictionary="'+k.id+'" data-track-title="'+k.term.replace(/"/g, '&quot;')+'">'+
      '<div class="kamus-term">'+k.term+'</div>'+ 
      '<span class="kamus-type">'+k.type+'</span>'+ 
      '<div class="kamus-def">'+k.def+'</div>'+ 
    '</div>';
  }).join('');
}
renderKamus();

document.addEventListener('click', function(e) {
  var card = e.target.closest('[data-track-dictionary]');
  if (card && window.AnalyticsTracker) {
    AnalyticsTracker.trackDictionary(card.getAttribute('data-track-dictionary'), card.getAttribute('data-track-title'));
  }
});
</script>
@endsection
