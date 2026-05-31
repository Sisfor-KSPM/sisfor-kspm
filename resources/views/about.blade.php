{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', 'KSPM SV IPB — About')

@section('styles')

/* Photo slider */
#aph-slider{display:flex;transition:transform 0.6s ease}
.div-card{cursor:pointer;transition:all 0.2s}
.div-card:hover{transform:translateY(-4px);box-shadow:0 14px 36px rgba(26,47,181,0.12);border-color:#1a2fb5!important}

/* Org */
.org-node{background:#fff;border:1.5px solid #d0d5e8;border-radius:10px;padding:10px 20px;font-size:0.82rem;font-weight:700;color:#0d0f1a;white-space:nowrap;transition:all 0.2s;cursor:default}
.org-node:hover{background:#e8ecfb;border-color:#1a2fb5;color:#1a2fb5}
.org-node.head{background:#1a2fb5;color:#fff;border-color:#1a2fb5}
.org-node.sec{background:#0d0f1a;color:#fff;border-color:#0d0f1a}
.org-line{width:2px;background:#d0d5e8;margin:0 auto}
.org-row{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}

@endsection

@section('content')

{{-- PHOTO HERO SLIDER --}}
<div class="w-full h-[480px] relative overflow-hidden mt-[68px]">
  <div class="flex h-full transition-[transform] duration-[0.6s]" id="aph-slider">
    <div class="min-w-full h-full bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center relative"><div class="absolute inset-0 bg-black/35 flex flex-col items-center justify-center text-white text-center p-10"><div class="text-[4rem] mb-4">🎓</div><div class="text-[1.4rem] font-bold mb-1.5">Sekolah Pasar Modal KSPM SV IPB</div><div class="text-[0.85rem] text-white/65">Edukasi investasi untuk mahasiswa Indonesia</div></div></div>
    <div class="min-w-full h-full bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center relative"><div class="absolute inset-0 bg-black/35 flex flex-col items-center justify-center text-white text-center p-10"><div class="text-[4rem] mb-4">🏛️</div><div class="text-[1.4rem] font-bold mb-1.5">Kunjungan ke Bursa Efek Indonesia</div><div class="text-[0.85rem] text-white/65">Pengalaman langsung di Gedung BEI Jakarta</div></div></div>
    <div class="min-w-full h-full bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center relative"><div class="absolute inset-0 bg-black/35 flex flex-col items-center justify-center text-white text-center p-10"><div class="text-[4rem] mb-4">🤝</div><div class="text-[1.4rem] font-bold mb-1.5">Company Visit & Networking</div><div class="text-[0.85rem] text-white/65">Membangun relasi dengan para profesional</div></div></div>
    <div class="min-w-full h-full bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center relative"><div class="absolute inset-0 bg-black/35 flex flex-col items-center justify-center text-white text-center p-10"><div class="text-[4rem] mb-4">🏆</div><div class="text-[1.4rem] font-bold mb-1.5">Investment Competition 2024</div><div class="text-[0.85rem] text-white/65">Adu strategi terbaik dalam dunia pasar modal</div></div></div>
  </div>
  <button class="absolute top-1/2 -translate-y-1/2 left-5 w-[38px] h-[38px] rounded-full bg-white/15 border border-white/25 text-white cursor-pointer flex items-center justify-center text-xl z-10 hover:bg-white/25" onclick="slidePhoto(-1)">‹</button>
  <button class="absolute top-1/2 -translate-y-1/2 right-5 w-[38px] h-[38px] rounded-full bg-white/15 border border-white/25 text-white cursor-pointer flex items-center justify-center text-xl z-10 hover:bg-white/25" onclick="slidePhoto(1)">›</button>
  <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-10" id="aph-nav"></div>
</div>

{{-- ABOUT HERO TEXT --}}
<div class="bg-[#1a2fb5] py-[60px] pb-20 text-white relative overflow-hidden">
  <div class="max-w-[1200px] mx-auto px-10 relative z-[2]">

    <div class="text-[0.75rem] font-bold tracking-[0.12em] uppercase text-white/50 mb-3.5">
      {{ $about->singkatan ?? 'Our Journey So Far' }}
    </div>

    <h1 class="text-[clamp(2.2rem,4.5vw,3.5rem)] font-medium leading-[1.1] mb-[18px]">
      {!! nl2br(e($about->nama ?? 'Kelompok Studi Pasar Modal')) !!}
    </h1>

    @if($about?->kepanjangan)
      <p class="text-lg text-white/90 font-medium mb-4">
        {{ $about->kepanjangan }}
      </p>
    @endif

    @if($about?->deskripsi)
      <p class="text-base text-white/70 leading-[1.8] max-w-[640px] mb-4">
        {{ $about->deskripsi }}
      </p>
    @endif

    @if($about?->visi)
      <p class="text-base text-white/70 leading-[1.8] max-w-[640px]">
        <span class="font-semibold text-white">Vision :</span>
        {{ $about->visi }}
      </p>
    @endif

  </div>
</div>

{{-- JOURNEY --}}
<section class="bg-white py-24">
  <div class="max-w-[1200px] mx-auto px-10">
    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">Perjalanan Kami</div>
    <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] font-medium">Dari Awal Hingga Kini</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-[72px] items-start mt-12">
      <!-- Stats grid -->
      <div class="rounded-3xl overflow-hidden border border-[#d0d5e8] bg-white" data-aos="fade-right">

        <div class="bg-gradient-to-br from-[#0d1a6e] via-[#1a2fb5] to-[#2d4ee0] p-8 relative overflow-hidden">
          <div class="text-[3.6rem] font-black leading-none text-white tracking-[-0.02em]">
            {{ $about->tahun_berdiri ?? '-' }}
          </div>

          <div class="text-[0.68rem] text-white/50 uppercase tracking-[0.1em] font-bold mt-1">
            Tahun Berdiri
          </div>
        </div>

        <div class="grid grid-cols-2 gap-px bg-[#d0d5e8']">

          <div class="bg-white px-[22px] py-[18px] hover:bg-[#e8ecfb] transition-colors">
            <div class="text-[1.5rem] font-black text-[#1a2fb5] leading-none">
              {{ $about->total_anggota ?? '-' }}
            </div>
            <div class="text-[0.7rem] text-[#5a6080] mt-1 font-medium">
              Anggota & Alumni
            </div>
          </div>

          <div class="bg-white px-[22px] py-[18px] hover:bg-[#e8ecfb] transition-colors">
            <div class="text-[1.5rem] font-black text-[#1a2fb5] leading-none">
              {{ $about->tahun_aktif ?? '-' }}
            </div>
            <div class="text-[0.7rem] text-[#5a6080] mt-1 font-medium">
              Tahun Aktif
            </div>
          </div>

          <div class="bg-white px-[22px] py-[18px] hover:bg-[#e8ecfb] transition-colors">
            <div class="text-[1.5rem] font-black text-[#1a2fb5] leading-none">
              {{ $about->program_kerja ?? '-' }}
            </div>
            <div class="text-[0.7rem] text-[#5a6080] mt-1 font-medium">
              Program Kerja
            </div>
          </div>

          <div class="bg-white px-[22px] py-[18px] hover:bg-[#e8ecfb] transition-colors">
            <div class="text-[1.5rem] font-black text-[#1a2fb5] leading-none">
              {{ $about->publikasi_riset ?? '-' }}
            </div>
            <div class="text-[0.7rem] text-[#5a6080] mt-1 font-medium">
              Publikasi Riset
            </div>
          </div>

        </div>
      </div>
      
      <div data-aos="fade-left">

        @if($about?->deskripsi)
          <p class="text-[0.92rem] text-[#5a6080] leading-[1.85] mb-[18px]">
            {{ $about->deskripsi }}
          </p>
        @endif

        @if($about?->visi)
          <p class="text-[0.92rem] text-[#5a6080] leading-[1.85] mb-[18px]">
            <span class="font-bold text-[#0d0f1a]">
              Visi
            </span>
            <br>
            {{ $about->visi }}
          </p>
        @endif

        @if($about?->misi)
          <p class="text-[0.92rem] text-[#5a6080] leading-[1.85]">
            <span class="font-bold text-[#0d0f1a]">
              Misi
            </span>
            <br>
            {!! nl2br(e($about->misi)) !!}
          </p>
        @endif

      </div>
    </div>
  </div>
</section>

{{-- ORG STRUCTURE --}}
<section class="bg-[#f7f8fc] py-24">
  <div class="max-w-[1200px] mx-auto px-10">
    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">Struktur Organisasi</div>
    <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] font-medium mb-12">KSPM SV IPB 2026 Organizational Structure</h2>
    <div class="text-center space-y-4">
      <div class="flex justify-center"><div class="org-node head">CEO KSPM</div></div>
      <div class="org-line h-6"></div>
      <div class="flex justify-center"><div class="org-node sec">Vice CEO KSPM</div></div>
      <div class="org-line h-6"></div>
      <div class="org-row">
        <div class="org-node">Bendahara I</div>
        <div class="org-node">Bendahara II</div>
        <div class="org-node">Sekretaris I</div>
        <div class="org-node">Sekretaris II</div>
      </div>
      <div class="org-line h-6"></div>
      <div class="org-row">
        <div class="org-node">Div. Riset & Analisis</div>
        <div class="org-node">Div. Edukasi & Training</div>
        <div class="org-node">Div. Media & Kreatif</div>
        <div class="org-node">Div. Public Relations</div>
        <div class="org-node">Div. Event & Program</div>
        <div class="org-node">Div. IT & Digital</div>
      </div>
    </div>
  </div>
</section>

{{-- DIVISIONS --}}
<section class="bg-white py-24">
  <div class="max-w-[1200px] mx-auto px-10">
    <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">Divisi Kami</div>
    <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] font-medium mb-10">Divisi KSPM SV IPB</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="div-grid"></div>
  </div>
</section>

{{-- DIVISION MODAL --}}
<div class="fixed inset-0 z-[600] bg-black/65 backdrop-blur-[10px] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-[0.25s]" id="div-modal" onclick="if(event.target===this)closeDivModal()">
  <div style="transform:translateY(20px);transition:transform 0.25s" id="div-modal-box" class="bg-white rounded-[22px] w-full max-w-[660px] max-h-[90vh] overflow-y-auto relative shadow-[0_36px_90px_rgba(0,0,0,0.2)] mx-4">
    <div class="bg-gradient-to-br from-[#0d1a6e] to-[#1e38cc] pt-9 pb-7 px-9 text-white relative rounded-t-[22px]">
      <button class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white/10 text-white cursor-pointer flex items-center justify-center hover:bg-white/20 border-none text-lg" onclick="closeDivModal()">✕</button>
      <div class="text-[2.2rem] mb-2.5" id="dm-icon"></div>
      <div class="text-[1.7rem] font-extrabold mb-[7px]" id="dm-title"></div>
      <div class="text-[0.84rem] text-white/65 leading-[1.65]" id="dm-sub"></div>
    </div>
    <div class="p-9">
      <div class="mb-6"><div class="text-[0.75rem] font-bold uppercase tracking-[0.08em] text-[#1a2fb5] mb-3">Tentang Kami</div><div class="text-[0.88rem] text-[#5a6080] leading-[1.8]" id="dm-desc"></div></div>
      <div class="mb-6"><div class="text-[0.75rem] font-bold uppercase tracking-[0.08em] text-[#1a2fb5] mb-3">Tim Kami</div><div class="grid grid-cols-[repeat(auto-fill,minmax(110px,1fr))] gap-2.5 mt-3.5" id="dm-members"></div></div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script>

/* PHOTO SLIDER */
var aphIdx=0;
var aphSlider=document.getElementById('aph-slider');
var aphTotal=aphSlider.children.length;
var aphNavEl=document.getElementById('aph-nav');

for(var i=0;i<aphTotal;i++){
  var d=document.createElement('button');
  d.className='w-2 h-2 rounded-full bg-white/40 border-none cursor-pointer transition-all '+(i===0?'bg-white! w-5!':'');
  d.style.cssText=i===0?'background:#fff;width:18px;border-radius:3px;height:7px':'background:rgba(255,255,255,0.4);width:8px;height:8px;border-radius:50%';
  (function(idx){d.onclick=function(){goAph(idx);};})(i);
  aphNavEl.appendChild(d);
}

function goAph(n){
  aphIdx=n;
  aphSlider.style.transform='translateX(-'+n+'00%)';
  var dots=aphNavEl.children;
  for(var i=0;i<dots.length;i++){
    dots[i].style.cssText=i===n?'background:#fff;width:18px;border-radius:3px;height:7px':'background:rgba(255,255,255,0.4);width:8px;height:8px;border-radius:50%';
  }
}

function slidePhoto(dir){goAph((aphIdx+dir+aphTotal)%aphTotal);}

setInterval(function(){slidePhoto(1);},5000);

/* DIVISIONS DATA */
var divisiData=[
  {nama:'BPH (Badan Pengurus Harian)',icon:'<img class="h-10" src="admin.png" alt="education">',desc:'Leading organizational strategy, coordination, and governance of KSPM.',fullDesc:'Badan Pengurus Harian (BPH), consisting of the CEO, Vice CEO, Secretary, and Treasurer, serves as the central pillar of KSPM\'s organizational structure. BPH is responsible for setting strategic direction, coordinating all divisions, and ensuring that every program aligns with KSPM\'s vision and mission.With strong leadership and structured governance, BPH becomes the driving force behind KSPM\'s stability, growth, and sustainability',members:[{initials:'KT',name:'Kangkung Tumis.',role:'CEO'},{initials:'BS',name:'Budi S.',role:'Vice CEO'},{initials:'CR',name:'Citra R.',role:'Bendahara 1'},{initials:'DP',name:'Dika P.',role:'Bendahara 2'}]},
  {nama:'Public Relations',icon:'<img class="h-10" src="pl.png" alt="education">',desc:'Managing external communication, partnerships, and KSPM\'s public image.',fullDesc:"The Public Relation division manages external communication, develops strategic partnerships, and maintains a positive and professional image of KSPM. Through networking, collaboration, and effective communication, this division plays an important role in expanding KSPM's presence and building meaningful relationships.With strong external relations, KSPM continues to grow — reaching wider and creating greater opportunities for its members.",members:[{initials:'KS',name:'Kevin S.',role:'Kadiv'},{initials:'LM',name:'Lisa M.',role:'Anggota'}]},
  {nama:'Analyze Trading',icon:'<img class="h-10" src="at.png" alt="education">',desc:'Conducting technical and fundamental market analysis for investment insights.',fullDesc:'The Analysis Trading division focuses on stock market analysis through both technical and fundamental approaches, providing a solid framework to understand market movements. From identifying trends to conducting in-depth research, this division delivers insights that support members in making informed and well-calculated investment decisions. Through a disciplined and analytical mindset, Analysis Trading helps sharpen critical thinking and build a comprehensive understanding of market dynamics.',members:[{initials:'MA',name:'Maya A.',role:'Kadiv'},{initials:'NR',name:'Nanda R.',role:'Anggota'},{initials:'OP',name:'Oscar P.',role:'Anggota'}]},
  {nama:'Media Creative',icon:'<img class="h-10" src="media.png" alt="education">',desc:'Creating digital content, visual branding, and creative media for KSPM.',fullDesc:"The Media Creative division is responsible for managing and developing digital content across various platforms, delivering informative and engaging content related to capital markets and investment. By combining visual storytelling with strategic communication, this division ensures that every content is creative, clear, and purposeful. Through continuous innovation, Media Creative plays a key role in amplifying KSPM's voice and expanding its reach.",members:[{initials:'HM',name:'Hana M.',role:'Kadiv'},{initials:'IR',name:'Irfan R.',role:'Anggota'},{initials:'JA',name:'Julia A.',role:'Anggota'}]},
  {nama:'Education',icon:'<img class="h-10" src="edu.png" alt="education">',desc:'Delivering investment education and improving financial literacy among members.',fullDesc:"The Education division focuses on designing and delivering structured learning programs in investment and capital markets, tailored for members at every level. Its mission is to enhance financial literacy and equip members with the knowledge, skills, and confidence to navigate the investment world. Through continuous learning and development, the Education division lays a strong foundation for KSPM's growth — one lesson at a time.",members:[{initials:'EF',name:'Eka F.',role:'Kadiv'},{initials:'FR',name:'Fani R.',role:'Anggota'},{initials:'GA',name:'Gilang A.',role:'Anggota'}]}
];

var divGrid=document.getElementById('div-grid');
if(divGrid){
  divGrid.innerHTML=divisiData.map(function(d,i){
    return '<div class="div-card bg-[#f7f8fc] border border-[#d0d5e8] rounded-[18px] p-7 hover:border-[#1a2fb5] hover:bg-[#e8ecfb]" data-aos="fade-up" data-aos-delay="'+(i*60)+'" onclick="openDivModal('+i+')">'+
      '<div class="text-[2rem] mb-3">'+d.icon+'</div>'+
      '<div class="text-[0.95rem] font-bold text-[#0d0f1a] mb-1.5">'+d.nama+'</div>'+
      '<div class="text-[0.82rem] text-[#5a6080] leading-[1.65] mb-4">'+d.desc+'</div>'+
      '<div class="text-[0.78rem] font-bold text-[#1a2fb5]">Lihat Detail →</div>'+
    '</div>';
  }).join('');
}

function openDivModal(idx){
  var d=divisiData[idx];
  document.getElementById('dm-title').textContent=d.nama;
  document.getElementById('dm-sub').textContent=d.desc;
  document.getElementById('dm-desc').textContent=d.fullDesc;
  document.getElementById('dm-members').innerHTML=d.members.map(function(m){
    return '<div class="bg-[#f7f8fc] border border-[#d0d5e8] rounded-xl p-3.5 text-center">'+
      '<div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#0d1a6e] to-[#1a2fb5] flex items-center justify-center text-white font-extrabold text-[0.85rem] mx-auto mb-2">'+m.initials+'</div>'+
      '<div class="text-[0.72rem] font-bold text-[#0d0f1a] mb-0.5">'+m.name+'</div>'+
      '<div class="text-[0.62rem] text-[#1a2fb5] font-semibold">'+m.role+'</div></div>';
  }).join('');
  var modal=document.getElementById('div-modal');
  var box=document.getElementById('div-modal-box');
  modal.style.opacity='1';modal.style.pointerEvents='all';
  box.style.transform='translateY(0)';
}

function closeDivModal(){
  var modal=document.getElementById('div-modal');
  var box=document.getElementById('div-modal-box');
  modal.style.opacity='0';modal.style.pointerEvents='none';
  box.style.transform='translateY(20px)';
}

</script>

@endsection
